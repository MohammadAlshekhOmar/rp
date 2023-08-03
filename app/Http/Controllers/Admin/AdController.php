<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Http\Requests\Admin\AdRequest;
use App\Http\Requests\Admin\AdRequestEdit;
use App\Services\AdService;
use App\Services\ProviderService;

class AdController extends Controller
{
    public function index(AdService $adService, ProviderService $providerService)
    {
        $ads = $adService->all();
        $title = __('locale.ads');
        $model = 'Ad';
        $findRoute = route('admin.ads.find');
        $addRoute = route('admin.ads.add');
        $editRoute = route('admin.ads.edit');
        $acceptRoute = route('admin.ads.accept');
        $rejectRoute = route('admin.ads.reject');
        $deleteRoute = route('admin.ads.delete');

        return view('Admin.SubViews.Ad.index', [
            'ads' => $ads,
            'providers' => $providerService->all(0),
            'title' => $title,
            'model' => $model,
            'findRoute' => $findRoute,
            'addRoute' => $addRoute,
            'editRoute' => $editRoute,
            'acceptRoute' => $acceptRoute,
            'rejectRoute' => $rejectRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function find(Request $request, AdService $adService)
    {
        $ad = $adService->find($request->id);
        if ($ad) {
            return MyHelper::responseJSON('تم جلب المعلومات بنجاح', 200, $ad);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function add(AdRequest $request, AdService $adService)
    {
        $ad = $adService->add($request->all(), $request->provider_id);
        if ($ad) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $ad);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function edit(AdRequestEdit $request, AdService $adService)
    {
        $ad = $adService->edit($request->all());
        if ($ad) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $ad);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function accept(Request $request, AdService $adService)
    {
        $ad = $adService->accept($request->id);
        if ($ad) {
            return MyHelper::responseJSON('تم القبول بنجاح', 200, $ad);
        } else {
            return MyHelper::responseJSON('لا يوجد مستخدمين', 500);
        }
    }

    public function reject(Request $request, AdService $adService)
    {
        $ad = $adService->reject($request->id);
        if ($ad) {
            return MyHelper::responseJSON('تم الرفض بنجاح', 200, $ad);
        } else {
            return MyHelper::responseJSON('لا يوجد مستخدمين', 500);
        }
    }
}
