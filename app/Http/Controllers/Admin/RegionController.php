<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Http\Requests\Admin\NameRequest;
use App\Services\RegionService;

class RegionController extends Controller
{
    public function index(RegionService $regionService)
    {
        $regions = $regionService->all();
        $title = __('locale.regions');
        $model = 'Region';
        $findRoute = route('admin.regions.find');
        $addRoute = route('admin.regions.add');
        $editRoute = route('admin.regions.edit');
        $deleteRoute = route('admin.regions.delete');

        return view('Admin.SubViews.Region.index', [
            'regions' => $regions,
            'title' => $title,
            'model' => $model,
            'findRoute' => $findRoute,
            'addRoute' => $addRoute,
            'editRoute' => $editRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function find(Request $request, RegionService $regionService)
    {
        $region = $regionService->find($request->id);
        if ($region) {
            return MyHelper::responseJSON('تم جلب المعلومات بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function add(NameRequest $request, RegionService $regionService)
    {
        $region = $regionService->add($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function edit(NameRequest $request, RegionService $regionService)
    {
        $region = $regionService->edit($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
