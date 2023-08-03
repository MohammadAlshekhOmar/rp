<?php

namespace App\Http\Controllers\Both;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Services\PaymentMethodService;

class PaymentMethodController extends Controller
{
    public function all(PaymentMethodService $paymentMethodService)
    {
        $paymentMethods = $paymentMethodService->all();
        if ($paymentMethods) {
            $paymentMethods = PaymentMethodResource::collection($paymentMethods);
            return MyHelper::responseJSON(__('api.paymentMethodExists'), 200, $paymentMethods);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
