<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NameRequest;
use App\Services\PaymentMethodService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(PaymentMethodService $paymentMethodService)
    {
        $paymentMethods = $paymentMethodService->all();
        $title = __('locale.paymentMethods');
        $model = 'PaymentMethod';
        $findRoute = route('admin.paymentMethods.find');
        $addRoute = route('admin.paymentMethods.add');
        $editRoute = route('admin.paymentMethods.edit');
        $deleteRoute = route('admin.paymentMethods.delete');

        return view('Admin.SubViews.PaymentMethod.index', [
            'paymentMethods' => $paymentMethods,
            'title' => $title,
            'model' => $model,
            'findRoute' => $findRoute,
            'addRoute' => $addRoute,
            'editRoute' => $editRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function find(Request $request, PaymentMethodService $paymentMethodService)
    {
        $region = $paymentMethodService->find($request->id);
        if ($region) {
            return MyHelper::responseJSON('تم جلب المعلومات بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function add(NameRequest $request, PaymentMethodService $paymentMethodService)
    {
        $region = $paymentMethodService->add($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function edit(NameRequest $request, PaymentMethodService $paymentMethodService)
    {
        $region = $paymentMethodService->edit($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
