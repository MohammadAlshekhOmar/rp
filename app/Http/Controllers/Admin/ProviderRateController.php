<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderRateController extends Controller
{
    public function index(Request $request, ProviderService $providerService)
    {
        $providerRates = $providerService->rates($request->provider_id);
        $title = __('locale.providerRate');
        $model = 'ProviderRate';
        $deleteRoute = route('admin.providerRates.delete');

        return view('Admin.SubViews.Provider.rates', [
            'providerRates' => $providerRates,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }
}
