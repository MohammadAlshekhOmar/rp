<?php

namespace App\Http\Controllers\Both;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Helpers\MyHelper;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function get(NotificationService $notificationService)
    {
        if (auth('api')->check()) {
            $notifications = $notificationService->getByUser(auth('api')->user()->id);
        } else {
            $notifications = $notificationService->getByProvider(auth('provider')->user()->id);
        }

        if ($notifications || empty($notifications)) {
            $notifications = NotificationResource::collection($notifications);
            return MyHelper::responseJSON(__('api.notificationExists'), 200, $notifications);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
