<?php

namespace App\Http\Controllers\Provider;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\OrderRequestCheckId;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getByStatus(Request $request, OrderService $orderService)
    {
        $orders = $orderService->getByStatus($request->status_id, auth('provider')->user()->id);
        if ($orders) {
            $orders = OrderResource::collection($orders);
            return MyHelper::responseJSON(__('api.orderExists'), 200, $orders);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function details(OrderRequestCheckId $request, OrderService $orderService)
    {
        $order = $orderService->find($request->order_id);
        if ($order) {
            $order = OrderResource::make($order);
            return MyHelper::responseJSON(__('api.orderExists'), 200, $order);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function accept(OrderRequestCheckId $request, OrderService $orderService)
    {
        $order = $orderService->accept($request->order_id, auth('provider')->user()->id);
        if ($order) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $order);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function reject(OrderRequestCheckId $request, OrderService $orderService)
    {
        $order = $orderService->reject($request->order_id, auth('provider')->user()->id);
        if ($order) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $order);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function finish(OrderRequestCheckId $request, OrderService $orderService)
    {
        $order = $orderService->finish($request->order_id);
        if ($order) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $order);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
