<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function all()
    {
        $admins = Admin::withTrashed()->get();
        $admins->shift();
        return $admins;
    }

    public function find($id)
    {
        return Admin::withTrashed()->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        $request['password'] = Hash::make($request['password']);
        $admin = Admin::create($request);
        $admin->addMedia($request['image'])->toMediaCollection('Admin');
        $admin->assignRole($request['role_id']);
        DB::commit();
        return $admin;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $admin = Admin::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $admin->clearMediaCollection('Admin');
            $admin->addMedia($request['image'])->toMediaCollection('Admin');
        }

        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            unset($request['password']);
        }
        $admin->update($request);
        $admin->roles()->detach();
        $admin->assignRole($request['role_id']);
        DB::commit();
        return $admin;
    }
}
