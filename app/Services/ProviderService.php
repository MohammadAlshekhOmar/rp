<?php

namespace App\Services;

use App\Models\FcmToken;
use App\Models\Provider;
use App\Models\ProviderRate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ProviderService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return Provider::withTrashed()->with(['media', 'services', 'regions' => function ($q) {
                $q->with('region');
            }])->get();
        } else {
            return Provider::with(['media', 'services', 'regions' => function ($q) {
                $q->with('region');
            }])->get();
        }
    }

    public function find($id)
    {
        return Provider::withTrashed()->with(['media', 'services', 'regions' => function ($q) {
            $q->with('region');
        }])->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        $request['password'] = Hash::make($request['password']);
        $code = 1111;
        $request['verification_code'] = $code;
        $provider = Provider::create($request);
        $provider->addMedia($request['image'])->toMediaCollection('Provider');

        if (isset($request['previous_jobs'])) {
            foreach ($request['previous_jobs'] as $previous_job) {
                $provider->addMedia($previous_job)->withCustomProperties(['previous_jobs' => true])->toMediaCollection('Provider');
            }
        }

        foreach ($request['regions'] as $region) {
            $provider->regions()->create([
                'region_id' => $region,
            ]);
        }

        if (isset($request['fcm_token'])) {
            $messaging = Firebase::messaging();
            $messaging->subscribeToTopic('all', $request['fcm_token']);
            $messaging->subscribeToTopic('providers', $request['fcm_token']);

            if (FcmToken::where('token', $request['fcm_token'])->exists()) {
                $fcmToken = FcmToken::where('token', $request['fcm_token'])->first();
                $fcmToken->update([
                    'tokenable_type' => get_class($provider),
                    'tokenable_id' => $provider->id,
                ]);
            } else {
                FcmToken::create([
                    'token' => $request['fcm_token'],
                    'tokenable_type' => get_class($provider),
                    'tokenable_id' => $provider->id,
                ]);
            }
        }

        DB::commit();
        return $provider;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $provider = Provider::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $provider->clearMediaCollectionExcept('Provider', $provider->getMedia('Provider', ['previous_jobs' => true]));
            $provider->addMedia($request['image'])->toMediaCollection('Provider');
        }
        if (isset($request['previous_jobs'])) {
            foreach ($request['previous_jobs'] as $previous_job) {
                $provider->addMedia($previous_job)->withCustomProperties(['previous_jobs' => true])->toMediaCollection('Provider');
            }
        }
        if (isset($request['regions'])) {
            $provider->regions()->delete();
            foreach ($request['regions'] as $region) {
                $provider->regions()->create([
                    'region_id' => $region,
                ]);
            }
        }
        if (isset($request['password'])) {
            $request['password'] = Hash::make($request['password']);
        } else {
            unset($request['password']);
        }

        $provider->update($request);
        DB::commit();
        return $provider;
    }

    public function editApi($request, $provider_id)
    {
        DB::beginTransaction();
        $provider = Provider::find($provider_id);
        if (isset($request['image'])) {
            $provider->clearMediaCollectionExcept('Provider', $provider->getMedia('Provider', ['previous_jobs' => true]));
            $provider->addMedia($request['image'])->toMediaCollection('Provider');
        }
        if (isset($request['previous_jobs'])) {
            // $provider->clearMediaCollectionExcept('Provider', array($provider->getFirstMediaUrl('Provider')));
            foreach ($request['previous_jobs'] as $previous_job) {
                $provider->addMedia($previous_job)->withCustomProperties(['previous_jobs' => true])->toMediaCollection('Provider');
            }
        }
        if (isset($request['regions'])) {
            $provider->regions()->delete();
            foreach ($request['regions'] as $region) {
                $provider->regions()->create([
                    'region_id' => $region,
                ]);
            }
        }
        $provider = Provider::with(['media'])->find($provider->id);
        $provider->update($request);
        DB::commit();
        return $provider;
    }

    public function changeLanguage($language_id, $provider_id)
    {
        $provider = Provider::find($provider_id);
        $provider->update([
            'language_id' => $language_id,
        ]);
        return $provider;
    }

    public function changePassword($request, $provider_id)
    {
        $provider = Provider::find($provider_id);

        if (!Hash::check($request['current_password'], $provider->password)) {
            return null;
        }

        $password = Hash::make($request['password']);
        $provider->update([
            'password' => $password,
        ]);
        return $provider;
    }

    public function delete($provider_id)
    {
        $provider = Provider::find($provider_id);
        $provider->tokens()->delete();
        $provider->fcmTokens()->delete();
        $provider->clearMediaCollection('Provider');
        $provider->delete();
        return $provider;
    }

    public function rates($provider_id)
    {
        $provider = Provider::with(['rates' => function ($q) {
            $q->with(['user']);
        }])->find($provider_id);
        return $provider->rates;
    }

    public function rate($request, $user_id)
    {
        return ProviderRate::updateOrCreate([
            'user_id' => $user_id,
            'provider_id' => $request['id']
        ], [
            'rate' => $request['rate'],
            'text' => $request['text']
        ]);
    }
}
