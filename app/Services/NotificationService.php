<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Provider;
use App\Models\User;
use App\Services\FirebaseNotification;

class NotificationService
{
    protected $firebaseNotification;
    public function __construct()
    {
        $this->firebaseNotification = new FirebaseNotification();
    }

    public function getByUser($user_id)
    {
        $user = User::find($user_id);
        $userNotifications = $user->notifications()->orderByDesc('id')->paginate(8)->items();
        foreach ($userNotifications as $userNotification) {
            $userNotification->users()->updateExistingPivot($user, ['is_read' => 1]);
        }
        return $userNotifications;
    }

    public function getByProvider($provider_id)
    {
        $provider = Provider::find($provider_id);
        $providerNotifications = $provider->notifications()->orderByDesc('id')->paginate(8)->items();
        foreach ($providerNotifications as $providerNotification) {
            $providerNotification->providers()->updateExistingPivot($provider, ['is_read' => 1]);
        }
        return $providerNotifications;
    }

    public function all()
    {
        return Notification::with(['users', 'providers'])->get();
    }

    public function find($id)
    {
        return Notification::with(['users', 'providers'])->find($id);
    }

    public function add($request)
    {
        $notification = FALSE;
        if (isset($request['users']) && isset($request['providers'])) {
            $notification = $this->firebaseNotification->sendBothNotification($request);
            if ($notification) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        if(isset($request['users'])) {
            $notification = $this->firebaseNotification->sendUsersNotification($request);
        }
        if (isset($request['providers'])) {
            $notification = $this->firebaseNotification->sendProvidersNotification($request);
        }
        if ($notification) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
