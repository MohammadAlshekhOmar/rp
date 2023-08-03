<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Services\ProviderService;
use App\Services\UserService;

class NotificationController extends Controller
{
    public function index(NotificationService $notificationService)
    {
        $notifications = $notificationService->all();
        $title = __('locale.notifications');
        $model = 'Notification';
        $deleteRoute = route('admin.notifications.delete');

        return view('Admin.SubViews.Notification.index', [
            'notifications' => $notifications,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, NotificationService $notificationService)
    {
        $page = 'معلومات الإشعار';
        $menu = __('locale.notifications');
        $menu_link = route('admin.notifications.index');

        return view('Admin.SubViews.Notification.show', [
            'notification' => $notificationService->find($request->id),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function showAdd(UserService $userService, ProviderService $providerService)
    {
        $page = 'إضافة إشعار';
        $menu = 'الإشعارات';
        $menu_link = route('admin.notifications.index');

        return view('Admin.SubViews.Notification.add', [
            'users' => $userService->all(0),
            'providers' => $providerService->all(0),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(NotificationRequest $request, NotificationService $notificationService)
    {
        $notifications = $notificationService->add($request->all());
        if ($notifications) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $notifications);
        } else {
            return MyHelper::responseJSON('لا يوجد مستخدمين', 500);
        }
    }
}
