<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(RoleService $roleService)
    {
        $roles = $roleService->all('admin');
        $title = __('locale.roles');

        return view('Admin.SubViews.Role.index', [
            'roles' => $roles,
            'title' => $title,
        ]);
    }

    public function showAdd()
    {
        $page = 'إضافة دور';
        $menu = __('locale.roles');
        $menu_link = route('admin.roles.index');

        $permissions = Permission::where('guard_name', 'admin')->get();
        $permissions = $permissions->groupBy('group');

        return view('Admin.SubViews.Role.add', [
            'permissions' => $permissions,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(RoleRequest $request, RoleService $roleService)
    {
        $role = $roleService->add($request->all());
        if ($role) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $role);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, RoleService $roleService)
    {
        $page = 'تعديل دور';
        $menu = __('locale.roles');
        $menu_link = route('admin.roles.index');

        $permissions = Permission::all();
        $permissions = $permissions->groupBy('group');

        $role = $roleService->find($request->id);
        return view('Admin.SubViews.Role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function edit(RoleRequest $request, RoleService $roleService)
    {
        $role = $roleService->edit($request->all());
        if ($role) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $role);
        } else {
            return MyHelper::responseJSON('لا يمكن حذف الصلاحيات الخاصة بالصلاحيات والأدوار لأنك الأدمن الرئيسي الوحيد هنا', 500);
        }
    }

    public function delete(Request $request, RoleService $roleService)
    {
        $role = $roleService->delete($request->id);
        if ($role) {
            return MyHelper::responseJSON('تم الحذف بنجاح', 200);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
