<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderService $orderService)
    {
        $orders = $orderService->all();
        $title = __('locale.orders');
        $model = 'Order';
        $deleteRoute = route('admin.orders.delete');

        return view('Admin.SubViews.Order.index', [
            'orders' => $orders,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, OrderService $orderService)
    {
        $page = 'معلومات الطلب';
        $menu = __('locale.orders');
        $menu_link = route('admin.orders.index');

        $order = $orderService->find($request->id);
        return view('Admin.SubViews.Order.show', [
            'order' => $order,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }
}
