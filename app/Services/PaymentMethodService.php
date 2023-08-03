<?php

namespace App\Services;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentMethodService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return PaymentMethod::withTrashed()->get();
        } else {
            return PaymentMethod::all();
        }
    }

    public function find($id)
    {
        $paymentMethod = PaymentMethod::withTrashed()->find($id);
        $paymentMethod->ar = [
            'name' => $paymentMethod->translate('ar')->name
        ];
        $paymentMethod->en = [
            'name' => $paymentMethod->translate('en')->name
        ];
        return $paymentMethod;
    }

    public function add($request)
    {
        return PaymentMethod::create($request);
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $paymentMethod = PaymentMethod::withTrashed()->find($request['id']);
        $paymentMethod->update($request);
        DB::commit();
        return $paymentMethod;
    }
}
