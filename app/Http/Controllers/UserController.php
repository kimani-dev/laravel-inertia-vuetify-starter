<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\OldEmailChangeMail;
use App\Models\User;
use App\Notifications\EmailChangeNotification;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return user with roles and permissions
        $users = User::all();
        foreach ($users as $user) {
            $roles = $user->getRoleNames();
            $permissions = $user->getAllPermissions();
            $user->roles = $roles;
            $user->permissions = $permissions;
        }
        return Inertia::render('Users/Index', [
            'users' => User::with('roles')->get()->map(function ($user) {
                $user->role = $user->roles->first()?->id;
                return $user;
            }),
            'roles' => Role::all(),
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
        // generate random password
        $password = Str::random(8);
        $user->password = Hash::make($password);
        $user->save();

        // assign role
        $user->assignRole($request->role);

        // notify user
        $user->notify(new WelcomeNotification($user, $password));

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

        // check if email has changed
        if ($user->email !== $validated['email']) {
            $oldEmail = $user->email;

            $user->email = $validated['email'];
            $user->email_verified_at = null;
            $user->save();
            // send email change notification
            $user->notify(new EmailChangeNotification($user));
            Mail::to($oldEmail)->send(new OldEmailChangeMail($user, $oldEmail));
        }

        $user->name = $validated['name'];
        $user->save();

        // replace role
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    // other user methods...
    function markNotificationsAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
