<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceRateController extends Controller
{
    public function index(Request $request, ServiceService $serviceService)
    {
        $serviceRates = $serviceService->rates($request->service_id);
        $title = __('locale.serviceRate');
        $model = 'ServiceRate';
        $deleteRoute = route('admin.serviceRates.delete');

        return view('Admin.SubViews.Service.rates', [
            'serviceRates' => $serviceRates,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }
}
