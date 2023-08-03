<?php

namespace App\Services;

use App\Models\FcmToken;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function loginPhone($request, &$reason = null)
    {
        if (User::onlyTrashed()->where('phone', $request['phone'])->exists() ||
            Provider::onlyTrashed()->where('phone', $request['phone'])->exists()) {
            $reason = 'USER_BLOCKED';
            return null;
        } else {
            if (User::where('phone', $request['phone'])->exists()) {
                $user = User::where('phone', $request['phone'])->first();
            } else if (Provider::where('phone', $request['phone'])->exists()) {
                $user = Provider::where('phone', $request['phone'])->first();
            }

            // generate active code
            $code = 1111;
            $user->update([
                'verification_code' => $code,
            ]);
            return true;
        }
    }

    public function active($request, &$reason = null)
    {
        DB::beginTransaction();
        if (User::where('phone', $request['phone'])->exists()) {
            $user = User::where('phone', $request['phone'])->first();
        } else if (Provider::where('phone', $request['phone'])->exists()) {
            $user = Provider::where('phone', $request['phone'])->first();
        }

        if ($user->verification_code != $request['verification_code']) {
            $reason = 'VERIFICATION_CODE_MISMATCH';
            return null;
        }

        $user->update([
            'verification_code' => 0,
        ]);

        auth('api')->user()?->tokens()?->delete();
        auth('provider')->user()?->tokens()?->delete();

        if (FcmToken::where('token', $request['fcm_token'])->exists()) {
            $fcmToken = FcmToken::where('token', $request['fcm_token'])->first();
            $fcmToken->update([
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->id
            ]);
        } else {
            FcmToken::create([
                'token' => $request['fcm_token'],
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->id
            ]);
        }

        DB::commit();
        return [
            "token" => $user->createToken("Device")->plainTextToken,
            "user" => $user,
        ];
    }

    public function loginEmail($request, &$reason = null)
    {
        if (User::onlyTrashed()->where('email', $request['email'])->exists() ||
            Provider::onlyTrashed()->where('email', $request['email'])->exists()) {
            $reason = 'USER_BLOCKED';
            return null;
        } else {
            if (User::where('email', $request['email'])->exists()) {
                $user = User::where('email', $request['email'])->first();
            } else if (Provider::where('email', $request['email'])->exists()) {
                $user = Provider::where('email', $request['email'])->first();
            }

            if (!Hash::check($request['password'], $user->password)) {
                $reason = 'INVALID_INPUT';
                return null;
            } else {

                auth('api')->user()?->tokens()?->delete();
                auth('provider')->user()?->tokens()?->delete();

                if (FcmToken::where('token', $request['fcm_token'])->exists()) {
                    $fcmToken = FcmToken::where('token', $request['fcm_token'])->first();
                    $fcmToken->update([
                        'tokenable_type' => get_class($user),
                        'tokenable_id' => $user->id
                    ]);
                } else {
                    FcmToken::create([
                        'token' => $request['fcm_token'],
                        'tokenable_type' => get_class($user),
                        'tokenable_id' => $user->id
                    ]);
                }

                return [
                    "token" => $user->createToken("Device")->plainTextToken,
                    "user" => $user,
                ];
            }
        }
    }

    public function forget($username, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $username)) ? 'email' : 'phone';
        if ($type == 'email') {
            $user = User::withTrashed()->where('email', $username)->first();
        } else {
            $user = User::withTrashed()->where('phone', $username)->first();
        }

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return null;
        } else {
            $rand = random_int(1111, 9999);
            $rand = 1111;
            //send email or sms

            $user->update([
                'verification_code' => $rand,
            ]);
            return $user;
        }
    }

    public function checkCode($request, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request['username'])) ? 'email' : 'phone';
        if ($type == 'email') {
            $user = User::withTrashed()->where('email', $request['username'])->first();
        } else {
            $user = User::withTrashed()->where('phone', $request['username'])->first();
        }

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return null;
        } else {
            if ($user->verification_code != $request['verification_code'] || $request['verification_code'] == 0) {
                $reason = 'CODE_NOT_MATCH';
                return null;
            } else {
                $user->update([
                    'verification_code' => 1,
                ]);
                return $user;
            }
        }
    }

    public function reset($request, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request['username'])) ? 'email' : 'phone';
        if ($type == 'email') {
            $user = User::withTrashed()->where('email', $request['username'])->first();
        } else {
            $user = User::withTrashed()->where('phone', $request['username'])->first();
        }

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return null;
        } else {
            if ($user->verification_code == 1) {
                $password = Hash::make($request['password']);
                $user->update([
                    'verification_code' => 0,
                    'password' => $password,
                ]);

                if (FcmToken::where('token', $request['fcm_token'])->exists()) {
                    $fcmToken = FcmToken::where('token', $request['fcm_token'])->first();
                    $fcmToken->update([
                        'tokenable_type' => get_class($user),
                        'tokenable_id' => $user->id
                    ]);
                } else {
                    FcmToken::create([
                        'token' => $request['fcm_token'],
                        'tokenable_type' => get_class($user),
                        'tokenable_id' => $user->id
                    ]);
                }

                $data = [
                    "token" => $user->createToken("Device")->plainTextToken,
                    "user" => $user,
                ];
                return $data;
            } else {
                $reason = 'ACCOUNT_NOT_READY_TO_RESET';
                return null;
            }
        }
    }
}
