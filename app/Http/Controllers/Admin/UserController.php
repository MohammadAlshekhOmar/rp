<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserRequestEdit;
use App\Services\UserService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Exports\UsersExport;
use App\Services\RegionService;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(UserService $userService)
    {
        $users = $userService->all();
        $title = __('locale.users');
        $model = 'User';
        $addRoute = route('admin.users.add');
        $deleteRoute = route('admin.users.delete');

        return view('Admin.SubViews.User.index', [
            'users' => $users,
            'title' => $title,
            'model' => $model,
            'addRoute' => $addRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, UserService $userService)
    {
        $page = 'معلومات المستخدم';
        $menu = __('locale.users');
        $menu_link = route('admin.users.index');

        $user = $userService->find($request->id);
        return view('Admin.SubViews.User.show', [
            'user' => $user,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function showAdd(LanguageService $languageService, RegionService $regionService)
    {
        $page = 'إضافة مستخدم';
        $menu = __('locale.users');
        $menu_link = route('admin.users.index');

        return view('Admin.SubViews.User.add', [
            'languages' => $languageService->all(),
            'regions' => $regionService->all(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(UserRequest $request, UserService $userService)
    {
        $user = $userService->add($request->all());
        if ($user) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $user);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, UserService $userService, LanguageService $languageService, RegionService $regionService)
    {
        $page = 'تعديل مستخدم';
        $menu = __('locale.users');
        $menu_link = route('admin.users.index');

        $user = $userService->find($request->id);
        return view('Admin.SubViews.User.edit', [
            'user' => $user,
            'languages' => $languageService->all(),
            'regions' => $regionService->all(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function edit(UserRequestEdit $request, UserService $userService)
    {
        $user = $userService->edit($request->all());
        if ($user) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $user);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'Users.xlsx');
    }
}
