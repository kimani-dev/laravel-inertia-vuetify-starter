<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Users\Role;
use App\Models\Users\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => User::with('roles')
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%');
                })
                ->when($request->role, function ($query, $role) {
                    $query->whereHas('roles', function ($query) use ($role) {
                        $query->where('name', $role);
                    });
                })
                ->paginate($request->itemsPerPage ?? 10, ['*'], 'page', $request->page ?? 1),
            'roles' => Inertia::defer(fn() => Role::all()),
            'filterOptions' => [
                'role' => Role::all()->map(function ($role) {
                    return [
                        'value' => $role->name,
                        'label' => $role->name,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make(Str::random(8));
        $user->save();

        $user->assignRole($request->role);
        $this->sendNewUserEmail($user);

        sendFlashMessage('success', 'User created successfully!');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $emailChanged = $user->email !== $validated['email'];
        $previousEmail = $user->email;

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        if ($emailChanged) {
            $this->sendEmailChangeNotification($user, $previousEmail);
        }

        $user->syncRoles([$request->role]);

        sendFlashMessage('success', 'User updated successfully!');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        sendFlashMessage('success', 'User deleted successfully!');

        return redirect()->route('users.index');
    }

    // other user methods...
    function markNotificationsAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function sendNewUserEmail(User $user)
    {
        $password = Str::random(8);
        $user->password = Hash::make($password);
        $user->save();

        $user->notify(new GeneralNotification(
            title: 'Welcome to'. config('app.name'),
            message: 'You have been registered as a user in the application.',
            action: route('profile.show'),
            mailable: 'emails.users.welcome_mail',
            data: [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
            ],
        ));
    }

    public function sendEmailChangeNotification(User $user, string $previousEmail)
    {
        $user->notify(new GeneralNotification(
            title: 'Email Change Notification',
            message: 'Your email has been changed from ' . $previousEmail . ' to ' . $user->email,
            action: route('profile.show'),
            mailable: 'emails.users.email_change_mail',
            data: [
                'name' => $user->name,
                'email' => $user->email,
                'previous_email' => $previousEmail,
            ],
        ));
    }
}
