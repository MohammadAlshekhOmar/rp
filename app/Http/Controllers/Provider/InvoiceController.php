<?php

namespace App\Http\Controllers\Provider;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\InvoiceRequest;
use App\Http\Requests\Provider\OrderRequestCheckId;
use App\Http\Resources\InvoiceDetailResource;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function details(OrderRequestCheckId $orderRequestCheckId, InvoiceService $invoiceService)
    {
        $invoice = $invoiceService->details($orderRequestCheckId->order_id);
        if ($invoice) {
            $invoice = InvoiceDetailResource::make($invoice);
            return MyHelper::responseJSON(__('api.invoiceDetail'), 200, $invoice);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function add(InvoiceRequest $request, InvoiceService $invoiceService)
    {
        $invoice = $invoiceService->add($request->only('order_id', 'discount', 'warranty_period'));
        if ($invoice) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $invoice);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
