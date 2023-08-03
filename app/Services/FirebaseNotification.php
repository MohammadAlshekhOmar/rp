<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseNotification
{
    function sendBothNotification($request)
    {
        DB::beginTransaction();
        if (in_array('all', $request['users'])) {
            $users = User::pluck('id');
        } else {
            $users = $request['users'];
        }

        if (in_array('all', $request['providers'])) {
            $providers = User::pluck('id');
        } else {
            $providers = $request['providers'];
        }

        $notification = $this->create_both_notification($request, $users, $providers);
        if ($request['users']) {
            if (in_array('all', $request['users'])) {
                $this->sendToTopic($request['title_ar'], $request['title_en'], $request['text_ar'], $request['text_en'], 'users');
            } else {
                foreach ($request['users'] as $user) {
                    $user_info = User::find($user);
                    if ($user_info->language) {
                        $language = $user_info->language->name;
                    } else {
                        $language = 'ar';
                    }
                    $this->sendToOne($request['title_' . $language], $request['text_' . $language], $user_info->fcm_token);
                }
            }
        }
        if ($request['providers']) {
            if (in_array('all', $request['providers'])) {
                $this->sendToTopic($request['title_ar'], $request['title_en'], $request['text_ar'], $request['text_en'], 'providers');
            } else {
                foreach ($request['providers'] as $provider) {
                    $provider_info = Provider::find($provider);
                    if ($provider_info->language) {
                        $language = $provider_info->language->name;
                    } else {
                        $language = 'ar';
                    }
                    $this->sendToOne($request['title_' . $language], $request['text_' . $language], $provider_info->fcm_token);
                }
            }
        }
        DB::commit();
        return $notification;
    }

    function create_both_notification($request, $users, $providers)
    {
        DB::beginTransaction();
        $notification = Notification::create([
            'ar' => [
                'title' => $request['title_ar'],
                'text' => $request['text_ar'],
            ],
            'en' => [
                'title' => $request['title_en'],
                'text' => $request['text_en'],
            ],
        ]);
        if ($notification) {
            if ($users) {
                foreach ($users as $user_id) {
                    $user = User::find($user_id);
                    $user->notifications()->attach($notification);
                }
            }
            if ($providers) {
                foreach ($providers as $provider_id) {
                    $provider = Provider::find($provider_id);
                    $provider->notifications()->attach($notification);
                }
            }
        }
        DB::commit();
        return $notification;
    }

    function sendUsersNotification($request)
    {
        DB::beginTransaction();
        $users = $request['users'];
        $topic = false;
        if (in_array('all', $users)) {
            $users = User::pluck('id');
            $topic = true;
        }

        if (count($users) > 0) {
            $notification = $this->create_user_notification($request, $users);
            if ($topic) {
                $this->sendToTopic($request['title_ar'], $request['title_en'], $request['text_ar'], $request['text_en'], 'users');
            } else {
                foreach ($users as $user) {
                    $user_info = User::find($user);
                    if ($user_info->language) {
                        $language = $user_info->language->name;
                    } else {
                        $language = 'ar';
                    }
                    $this->sendToOne($request['title_' . $language], $request['text_' . $language], $user_info->fcm_token);
                }
            }
            DB::commit();
            return $notification;
        } else {
            return null;
        }
    }

    function sendUserNotification($request, $user_id, $extra = null)
    {
        DB::beginTransaction();
        $user = User::find($user_id)->id;
        $notification = $this->create_user_notification($request, array($user));
        if ($notification) {
            $user = User::find($user_id);
            if ($user->fcm_token) {
                if ($user->language) {
                    $language = $user->language->name;
                } else {
                    $language = 'ar';
                }
                $this->sendToOne($request['title_' . $language], $request['text_' . $language], $user->fcm_token, $extra);
            }
            DB::commit();
            return $notification;
        } else {
            return null;
        }
    }

    function create_user_notification($request, $users)
    {
        DB::beginTransaction();
        $notification = Notification::create([
            'type' => $request['type'] ?? null,
            'order_id' => $request['order_id'] ?? null,
            'ar' => [
                'title' => $request['title_ar'],
                'text' => $request['text_ar'],
            ],
            'en' => [
                'title' => $request['title_en'],
                'text' => $request['text_en'],
            ],
        ]);
        if ($notification) {
            foreach ($users as $user_id) {
                $user = User::find($user_id);
                $user->notifications()->attach($notification);
            }
        }
        DB::commit();
        return $notification;
    }

    function sendProvidersNotification($request)
    {
        DB::beginTransaction();
        $providers = $request['providers'];
        $topic = false;
        if (in_array('all', $providers)) {
            $providers = Provider::pluck('id');
            $topic = true;
        }

        if (count($providers) > 0) {
            $notification = $this->create_provider_notification($request, $providers);
            if ($topic) {
                $this->sendToTopic($request['title_ar'], $request['title_en'], $request['text_ar'], $request['text_en'], 'providers');
            } else {
                foreach ($providers as $provider) {
                    $provider_info = Provider::find($provider);
                    if ($provider_info->language) {
                        $language = $provider_info->language->name;
                    } else {
                        $language = 'ar';
                    }
                    $this->sendToOne($request['title_' . $language], $request['text_' . $language], $provider_info->fcm_token);
                }
            }
            DB::commit();
            return $notification;
        } else {
            return null;
        }
    }

    function sendProviderNotification($request, $provider_id, $extra = null)
    {
        DB::beginTransaction();
        $provider = Provider::find($provider_id)->id;
        $notification = $this->create_provider_notification($request, array($provider));
        if ($notification) {
            $provider = Provider::find($provider_id);
            if ($provider->fcm_token) {
                if ($provider->language) {
                    $language = $provider->language->name;
                } else {
                    $language = 'ar';
                }
                $this->sendToOne($request['title_' . $language], $request['text_' . $language], $provider->fcm_token, $extra);
            }
            DB::commit();
            return $notification;
        } else {
            return null;
        }
    }

    function create_provider_notification($request, $providers)
    {
        DB::beginTransaction();
        $notification = Notification::create([
            'type' => $request['type'] ?? null,
            'order_id' => $request['order_id'] ?? null,
            'ar' => [
                'title' => $request['title_ar'],
                'text' => $request['text_ar'],
            ],
            'en' => [
                'title' => $request['title_en'],
                'text' => $request['text_en'],
            ],
        ]);

        if ($notification) {
            foreach ($providers as $provider_id) {
                $provider = Provider::find($provider_id);
                $provider->notifications()->attach($notification);
            }
        }
        DB::commit();
        return $notification;
    }

    public static function sendToTopic($title_ar, $title_en, $body_ar, $body_en, $topic)
    {
        DB::beginTransaction();
        $messaging = Firebase::messaging();
        $notification = MessagingNotification::fromArray([
            'title' => $title_ar,
            'body' => $body_ar,
            'data' => [
                'ar' => [
                    'title' => $title_ar,
                    'body' => $body_ar,
                ],
                'en' => [
                    'title' => $title_en,
                    'body' => $body_en,
                ],
            ],
        ]);

        $message = CloudMessage::new ();
        $message = $message->withTarget('topic', $topic);
        $message = $message->withNotification($notification);
        DB::commit();
        return $messaging->send($message);
    }

    public static function sendToOne($title, $body, $token, $extra = null)
    {
        if ($token) {
            DB::beginTransaction();
            $messaging = Firebase::messaging();
            $notification = MessagingNotification::fromArray([
                'title' => $title,
                'body' => $body,
            ]);

            $message = CloudMessage::new ();
            $message = $message->withNotification($notification);

            if ($extra) {
                $message = $message->withData($extra);
            } else {
                $message = $message->withData([
                    'action' => 'info',
                ]);
            }

            $validToken = $messaging->validateRegistrationTokens([$token])['valid'];
            if (count($validToken) > 0) {
                DB::commit();
                return $messaging->sendMulticast($message, $validToken, true);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
