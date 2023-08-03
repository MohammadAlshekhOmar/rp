<?php

namespace App\Services;

use App\Models\FcmToken;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UserService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return User::withTrashed()->with(['media'])->get();
        } else {
            return User::with(['media'])->get();
        }
    }

    public function find($id)
    {
        return User::withTrashed()->with(['media'])->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        $request['password'] = Hash::make($request['password']);
        $code = 1111;
        $request['verification_code'] = $code;
        $user = User::create($request);
        $user->addMedia($request['image'])->toMediaCollection('User');

        if (isset($request['fcm_token'])) {
            $messaging = Firebase::messaging();
            $messaging->subscribeToTopic('all', $request['fcm_token']);
            $messaging->subscribeToTopic('users', $request['fcm_token']);

            if (FcmToken::where('token', $request['fcm_token'])->exists()) {
                $fcmToken = FcmToken::where('token', $request['fcm_token'])->first();
                $fcmToken->update([
                    'tokenable_type' => get_class($user),
                    'tokenable_id' => $user->id,
                ]);
            } else {
                FcmToken::create([
                    'token' => $request['fcm_token'],
                    'tokenable_type' => get_class($user),
                    'tokenable_id' => $user->id,
                ]);
            }
        }

        DB::commit();
        return $user;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $user = User::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $user->clearMediaCollection('User');
            $user->addMedia($request['image'])->toMediaCollection('User');
        }

        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            unset($request['password']);
        }

        $user->update($request);
        DB::commit();
        return $user;
    }

    public function editApi($request, $user_id)
    {
        DB::beginTransaction();
        $user = User::find($user_id);
        if (isset($request['image'])) {
            $user->clearMediaCollection('User');
            $user->addMedia($request['image'])->toMediaCollection('User');
        }

        $user->update($request);
        DB::commit();
        return $user;
    }

    public function favorites($user_id)
    {
        $user = User::find($user_id);
        return [
            'service_favorites' => $user->service_favorites()->get(),
            'provider_favorites' => $user->provider_favorites()->get(),
        ];
    }

    public function favorite($request, $user_id)
    {
        $user = User::find($user_id);
        if ($request['type'] == 'service') {
            if ($user->service_favorites()->where('service_id', $request['id'])->exists()) {
                $user->service_favorites()->where('service_id', $request['id'])->delete();
            } else {
                $user->service_favorites()->firstOrCreate([
                    'service_id' => $request['id'],
                ]);
            }
        } else {
            if ($user->provider_favorites()->where('provider_id', $request['id'])->exists()) {
                $user->provider_favorites()->where('provider_id', $request['id'])->delete();
            } else {
                $user->provider_favorites()->firstOrCreate([
                    'provider_id' => $request['id'],
                ]);
            }
        }
        return true;
    }

    public function changeLanguage($language_id, $user_id)
    {
        $user = User::find($user_id);
        $user->update([
            'language_id' => $language_id,
        ]);
        return $user;
    }

    public function changePassword($request, $user_id)
    {
        $user = User::find($user_id);

        if (!Hash::check($request['current_password'], $user->password)) {
            return null;
        }

        $password = Hash::make($request['password']);
        $user->update([
            'password' => $password,
        ]);
        return $user;
    }

    public function delete($user_id)
    {
        $user = User::find($user_id);
        $user->tokens()->delete();
        $user->fcmTokens()->delete();
        $user->clearMediaCollection('User');
        $user->delete();
        return $user;
    }
}
