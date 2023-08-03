<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\AdminRequestEdit;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Helpers\MyHelper;

class AdminController extends Controller
{
    public function index(AdminService $adminService)
    {
        $admins = $adminService->all();
        $title = __('locale.admins');
        $model = 'Admin';
        $deleteRoute = route('admin.admins.delete');

        return view('Admin.SubViews.Admin.index', [
            'admins' => $admins,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function showAdd()
    {
        $page = 'إضافة مدير';
        $menu = __('locale.admins');
        $menu_link = route('admin.admins.index');

        return view('Admin.SubViews.Admin.add', [
            'roles' => Role::where('guard_name', 'admin')->get(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(AdminRequest $request, AdminService $adminService)
    {
        $admin = $adminService->add($request->all());
        if($admin) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $admin);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, AdminService $adminService)
    {
        $page = 'تعديل مدير';
        $menu = __('locale.admins');
        $menu_link = route('admin.admins.index');

        $admin = $adminService->find($request->id);
        return view('Admin.SubViews.Admin.edit', [
            'admin' => $admin,
            'roles' => Role::where('guard_name', 'admin')->get(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function edit(AdminRequestEdit $request, AdminService $adminService)
    {
        $admin = $adminService->edit($request->all());
        if ($admin) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $admin);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
