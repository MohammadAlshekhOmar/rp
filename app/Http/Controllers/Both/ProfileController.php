<?php

namespace App\Http\Controllers\Both;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Both\LanguageRequest;
use App\Http\Requests\Both\PasswordRequest;
use App\Http\Resources\ProviderDetailResource;
use App\Http\Resources\UserResource;
use App\Services\ProviderService;
use App\Services\UserService;

class ProfileController extends Controller
{
    public function get(UserService $userService, ProviderService $providerService)
    {
        if (auth('api')->check()) {
            $user = $userService->find(auth('api')->user()->id);
        } else {
            $user = $providerService->find(auth('provider')->user()->id);
        }
        if ($user) {
            if (auth('api')->check()) {
                $user = UserResource::make($user);
            } else {
                $user = ProviderDetailResource::make($user);
            }
            return MyHelper::responseJSON(__('api.userExists'), 200, $user);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function changeLanguage(LanguageRequest $request, UserService $userService, ProviderService $providerService)
    {
        if (auth('api')->check()) {
            $user = $userService->changeLanguage($request->language_id, auth('api')->user()->id);
        } else {
            $user = $providerService->changeLanguage($request->language_id, auth('provider')->user()->id);
        }
        if ($user) {
            return MyHelper::responseJSON(__('api.updateLanguageSuccessfully'), 200, $user);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function changePassword(PasswordRequest $request, UserService $userService, ProviderService $providerService)
    {
        if (auth('api')->check()) {
            $user = $userService->changePassword($request->only('current_password', 'password'), auth('api')->user()->id);
        } else {
            $user = $providerService->changePassword($request->only('current_password', 'password'), auth('provider')->user()->id);
        }
        if ($user) {
            return MyHelper::responseJSON(__('api.updatePasswordSuccessfully'), 200, $user);
        } else {
            return MyHelper::responseJSON(__('api.currentPasswordDontMatch'), 400);
        }
    }
}
