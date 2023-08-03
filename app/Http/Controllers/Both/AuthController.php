<?php

namespace App\Http\Controllers\Both;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Both\AuthPhoneRequest;
use App\Http\Requests\Both\AuthEmailRequest;
use App\Http\Requests\Both\ActiveRequest;
use App\Http\Requests\Both\CheckCodeRequest;
use App\Http\Requests\Both\ForgetRequest;
use App\Http\Requests\Both\ResetRequest;
use App\Services\AuthService;
use App\Services\ProviderService;
use App\Services\UserService;

class AuthController extends Controller
{
    public function loginPhone(AuthPhoneRequest $request, AuthService $authService)
    {
        $user = $authService->loginPhone($request->only('phone', 'type'), $reason);
        if ($user) {
            return MyHelper::responseJSON(__('api.sendSMSSuccessfully'), 200, $user);
        } else {
            if ($reason == 'USER_BLOCKED') {
                return MyHelper::responseJSON(__('api.userIsBlocked'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function active(ActiveRequest $request, AuthService $authService)
    {
        $user = $authService->active($request->only('phone', 'type', 'verification_code', 'fcm_token'), $reason);
        if ($user) {
            return MyHelper::responseJSON(__('api.activeSuccessfully'), 200, $user);
        } else {
            if ($reason == 'VERIFICATION_CODE_MISMATCH') {
                return MyHelper::responseJSON(__('api.incorrectCode'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function loginEmail(AuthEmailRequest $request, AuthService $authService)
    {
        $user = $authService->loginEmail($request->only('email', 'password', 'fcm_token'), $reason);
        if ($user) {
            return MyHelper::responseJSON(__('api.loginSuccessfully'), 200, $user);
        } else {
            if ($reason == 'USER_BLOCKED') {
                return MyHelper::responseJSON(__('api.userIsBlocked'), 400);
            } else if ($reason == 'INVALID_INPUT') {
                return MyHelper::responseJSON(__('api.loginFailEmail'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function forget(ForgetRequest $request, AuthService $authService)
    {
        $user = $authService->forget($request->username, $reason);
        if ($user) {
            $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request->username)) ? 'email' : 'phone';
            if ($type == 'email') {
                return MyHelper::responseJSON(__('api.sendEmailSuccessfully'), 200, $user);
            } else {
                return MyHelper::responseJSON(__('api.sendSMSSuccessfully'), 200, $user);
            }
        } else {
            if ($reason == 'USER_BLOCKED') {
                return MyHelper::responseJSON(__('api.userIsBlocked'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function checkCode(CheckCodeRequest $request, AuthService $authService)
    {
        $user = $authService->checkCode($request->only('username', 'verification_code'), $reason);
        if ($user) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $user);
        } else {
            if ($reason == 'CODE_NOT_MATCH') {
                return MyHelper::responseJSON(__('api.incorrectCode'), 400);
            } elseif ($reason == 'USER_BLOCKED') {
                return MyHelper::responseJSON(__('api.userIsBlocked'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function reset(ResetRequest $request, AuthService $authService)
    {
        $user = $authService->reset($request->only('username', 'password', 'fcm_token'), $reason);
        if ($user) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $user);
        } else {
            if ($reason == 'ACCOUNT_NOT_READY_TO_RESET') {
                return MyHelper::responseJSON(__('api.accountNotReady'), 400);
            } elseif ($reason == 'USER_BLOCKED') {
                return MyHelper::responseJSON(__('api.userIsBlocked'), 400);
            } else {
                return MyHelper::responseJSON(__('api.unknownError'), 500);
            }
        }
    }

    public function logout()
    {
        auth('api')->user()?->tokens()?->delete();
        auth('api')->user()?->fcmTokens()?->delete();
        auth('provider')->user()?->tokens()?->delete();
        auth('provider')->user()?->fcmTokens()?->delete();
        return MyHelper::responseJSON(__('api.logoutSuccessfully'), 200);
    }

    public function delete(UserService $userService, ProviderService $providerService)
    {
        if (auth('api')->check()) {
            $auth = $userService->delete(auth('api')->user()->id);
        } else {
            $auth = $providerService->delete(auth('provider')->user()->id);
        }
        if ($auth) {
            return MyHelper::responseJSON(__('api.deleteSuccessfully'), 200, $auth);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
