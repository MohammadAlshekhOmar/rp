<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Helpers\MyHelper;
use App\Http\Requests\Provider\OrderRequestCheckId;
use App\Http\Requests\User\ServiceIdRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function my(OrderService $orderService)
    {
        $orders = $orderService->my(auth('api')->user()->id);
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

    public function add(ServiceIdRequest $request, OrderService $orderService)
    {
        $order = $orderService->add($request->id, auth('api')->user()->id);
        if ($order) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $order);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
