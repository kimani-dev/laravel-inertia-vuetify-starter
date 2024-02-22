<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('read roles');

        return Inertia::render('Roles/Index', [
            'roles' => Role::all()
        ]);
    }

    public function show(Role $role)
    {
        $this->authorize('read roles');

        return Inertia::render('Roles/Show', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::all()
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);
        return redirect()->route('roles.index');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        if (isset($validated['name'])) {
            $role->name = $validated['name'];
            $role->save();
        }

        $role->syncPermissions($validated['permissions']);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete roles');

        $role->delete();

        return redirect()->route('roles.index');
    }
}
