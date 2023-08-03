<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $firebaseNotification;
    public function __construct()
    {
        $this->firebaseNotification = new FirebaseNotification();
    }

    public function all()
    {
        $orders = Order::withTrashed()->with(['user', 'service', 'order_status'])->get();
        foreach ($orders as $order) {
            if (Invoice::where('order_id', $order->id)->exists()) {
                $order['invoice_id'] = Invoice::where('order_id', $order->id)->first()->number;
            } else {
                $order['invoice_id'] = null;
            }
        }
        return $orders;
    }

    public function getByStatus($status_id, $provider_id)
    {
        return Order::with(['user', 'service', 'order_status'])->whereHas('service', function ($q) use ($provider_id) {
            $q->where('provider_id', $provider_id);
        })->where('order_status_id', $status_id)->get();
    }

    public function find($id)
    {
        $order = Order::withTrashed()->with(['user', 'service', 'order_status'])->find($id);
        if (Invoice::where('order_id', $order->id)->exists()) {
            $order['invoice_id'] = Invoice::where('order_id', $order->id)->first()->number;
        } else {
            $order['invoice_id'] = null;
        }
        return $order;
    }

    public function my($user_id)
    {
        return Order::with(['user', 'service', 'order_status'])->where('user_id', $user_id)->get();
    }

    public function add($service_id, $user_id)
    {
        DB::beginTransaction();
        $service = Service::find($service_id);
        $user = User::find($user_id);
        $order = Order::firstOrCreate([
            'user_id' => $user_id,
            'service_id' => $service_id,
        ]);

        $data = [
            'type' => 'add',
            'order_id' => $order->id,
            'title_ar' => 'طلب جديد',
            'title_en' => 'New Request',
            'text_ar' => 'لديك طلب جديد لخدمة (' . $service->name . ') من المستخدم (' . $user->name . ')',
            'text_en' => 'You have a new request for service (' . $service->name . ') from user (' . $user->name . ')',
        ];
        $extra = [
            'type' => 'add',
            'order_id' => $order->id,
        ];

        $this->firebaseNotification->sendProviderNotification($data, $service->provider_id, $extra);
        DB::commit();
        return $order;
    }

    public function accept($id, $provider_id)
    {
        DB::beginTransaction();
        $order = Order::with(['service', 'user'])->find($id);
        $provider = Provider::find($provider_id);
        $order->update([
            'provider_id' => $provider_id,
            'order_status_id' => OrderStatusEnum::ACCEPTED->value,
        ]);

        $data = [
            'type' => 'accept',
            'order_id' => $order->id,
            'title_ar' => 'قبول طلب',
            'title_en' => 'Accept Request',
            'text_ar' => 'تم قبول طلبك لخدمة (' . $order->service->name . ') من مزود الخدمة (' . $provider->name . ')',
            'text_en' => 'Your request for service (' . $order->service->name . ') has been accepted from provider (' . $provider->name . ')',
        ];
        $extra = [
            'type' => 'accept',
            'order_id' => $order->id,
        ];

        $this->firebaseNotification->sendUserNotification($data, $order->user_id, $extra);
        DB::commit();
        return $order;
    }

    public function reject($id, $provider_id)
    {
        DB::beginTransaction();
        $order = Order::with(['service', 'user'])->find($id);
        $provider = Provider::find($provider_id);
        $order->update([
            'provider_id' => $provider_id,
            'order_status_id' => OrderStatusEnum::REJECTED->value,
        ]);

        $data = [
            'type' => 'reject',
            'order_id' => $order->id,
            'title_ar' => 'رفض طلب',
            'title_en' => 'Reject Request',
            'text_ar' => 'عذراً ، تم رفض طلبك لخدمة (' . $order->service->name . ') من مزود الخدمة (' . $provider->name . ')',
            'text_en' => 'Sorry, your request for service (' . $order->service->name . ') was rejected by the service provider (' . $provider->name . ')',
        ];
        $extra = [
            'type' => 'reject',
            'order_id' => $order->id,
        ];

        $this->firebaseNotification->sendUserNotification($data, $order->user_id, $extra);
        DB::commit();
        return $order;
    }

    public function finish($id)
    {
        DB::beginTransaction();
        $order = Order::with(['service'])->find($id);
        $order->update([
            'order_status_id' => OrderStatusEnum::FINISHED->value,
        ]);

        $data = [
            'type' => 'finish',
            'order_id' => $order->id,
            'title_ar' => 'اكتمال خدمة',
            'title_en' => 'Service is completed',
            'text_ar' => 'تم تغيير حالة خدمتك (' . $order->service->name . ') لمكتملة ، يرجى تقييم الخدمة وتقيييم مزود الخدمة',
            'text_en' => 'Your service status has been changed (' . $order->service->name . ') to Completed Please rate the service and rate the service provider',
        ];
        $extra = [
            'type' => 'finish',
            'order_id' => $order->id,
        ];

        $this->firebaseNotification->sendUserNotification($data, $order->user_id, $extra);
        DB::commit();
        return $order;
    }
}
