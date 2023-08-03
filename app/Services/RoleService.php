<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function all()
    {
        return Role::whereNot('id', 1)->get();
    }

    public function find($id)
    {
        if ($id == 1) {
            abort(404);
        }
        return Role::find($id);
    }

    public function add($request)
    {
        $role = Role::create($request);
        $role->syncPermissions($request['permissions']);
        return $role;
    }

    public function edit($request)
    {
        if ($request['id'] == 1) {
            abort(404);
        }

        $role = Role::find($request['id']);
        $role->update($request);
        $role->syncPermissions($request['permissions']);
        return $role;
    }

    public function delete($id)
    {
        if ($id == 1) {
            abort(404);
        }

        $role = Role::find($id);
        $role->delete();
        return $role;
    }
}
