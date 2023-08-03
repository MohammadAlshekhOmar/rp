<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FavoriteRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UserEditRequest;
use App\Http\Resources\UserFavoriteResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    public function add(RegisterRequest $request, UserService $userService)
    {
        $user = $userService->add($request->only('name', 'email', 'phone', 'password', 'image', 'region_id'));
        if ($user) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $user);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function edit(UserEditRequest $request, UserService $userService)
    {
        $user = $userService->editApi($request->only('name', 'email', 'phone', 'image', 'region_id'), auth('api')->user()->id);
        if ($user) {
            $user = UserResource::make($user);
            return MyHelper::responseJSON(__('api.updateInformationSuccessfully'), 200, $user);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function favorites(UserService $userService)
    {
        $favorites = $userService->favorites(auth('api')->user()->id);
        if ($favorites['service_favorites']) {
            $service_favorites = UserFavoriteResource::collection($favorites['service_favorites']);
            $provider_favorites = UserFavoriteResource::collection($favorites['provider_favorites']);
            $data = [
                'service_favorites' => $service_favorites,
                'provider_favorites' => $provider_favorites,
            ];
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200, $data);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function favorite(FavoriteRequest $request, UserService $userService)
    {
        $favorite = $userService->favorite($request->only('id', 'type'), auth('api')->user()->id);
        if ($favorite) {
            return MyHelper::responseJSON(__('api.doneSuccessfully'), 200);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
