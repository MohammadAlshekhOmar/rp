<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function all()
    {
        return Invoice::with(['order'])->get();
    }

    public function find($id)
    {
        return Invoice::with(['order'])->find($id);
    }

    public function details($order_id)
    {
        return Invoice::with(['order'])->where('order_id', $order_id)->first();
    }

    public function add($request)
    {
        DB::beginTransaction();
        $number = mt_rand(100000, 999999);
        while (Invoice::where('number', $number)->exists()) {
            $number = mt_rand(100000, 999999);
        }
        $request['number'] = $number;
        $invoice = Invoice::create($request);
        DB::commit();
        return $invoice;
    }
}
