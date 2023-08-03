<?php

namespace App\Services;

use App\Models\Provider;
use App\Models\Warranty;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnCallback;

class WarrantyService
{
    public function all()
    {
        return Warranty::withTrashed()->with(['media', 'invoice' => function ($q) {
            $q->with(['order' => function ($q1) {
                $q1->with(['user', 'service' => function ($q2) {
                    $q2->with(['provider']);
                }]);
            }]);
        }])->get();
    }

    public function allUser($user_id)
    {
        return Warranty::withWhereHas('invoice', function ($q) use ($user_id) {
            $q->withWhereHas('order', function ($q1) use ($user_id) {
                $q1->where('user_id', $user_id)->withWhereHas('service');
            });
        })->get();
    }

    public function allProvider($provider_id)
    {
        return Warranty::withWhereHas('invoice', function ($q) use ($provider_id) {
            $q->withWhereHas('order', function ($q1) use ($provider_id) {
                $q1->withWhereHas('service', function ($q2) use ($provider_id) {
                    $q2->where('provider_id', $provider_id);
                });
            });
        })->get();
    }

    public function details($id)
    {
        return Warranty::with(['media', 'invoice' => function ($q) {
            $q->with(['order' => function ($q1) {
                $q1->with(['user', 'service' => function ($q2) {
                    $q2->with(['provider']);
                }]);
            }]);
        }])->find($id);
    }

    public function find($id)
    {
        return Warranty::withTrashed()->with(['media', 'invoice' => function ($q) {
            $q->with(['order' => function ($q1) {
                $q1->with(['user', 'service' => function ($q2) {
                    $q2->with(['provider']);
                }]);
            }]);
        }])->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        if (isset($request['file'])) {
            $warranty = Warranty::updateOrCreate([
                'invoice_id' => $request['invoice_id'],
            ]);
            $warranty->clearMediaCollection('Warranty');
            $warranty->addMedia($request['file'])->toMediaCollection('Warranty');
        } else {
            $warranty = Warranty::updateOrCreate([
                'invoice_id' => $request['invoice_id'],
            ], [
                'contract_value' => $request['contract_value'],
                'contract_date' => $request['contract_date'],
                'expiry_date' => $request['expiry_date'],
            ]);
            $warranty->clearMediaCollection('Warranty');
        }
        DB::commit();
        return $warranty;
    }
}
