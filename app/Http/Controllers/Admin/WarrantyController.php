<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WarrantyService;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function index(WarrantyService $warrantyService)
    {
        $warranties = $warrantyService->all();
        $title = __('locale.warranties');
        $model = 'Warranty';
        $deleteRoute = route('admin.warranties.delete');

        return view('Admin.SubViews.Warranty.index', [
            'warranties' => $warranties,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, WarrantyService $warrantyService)
    {
        $page = 'معلومات الفاتورة';
        $menu = __('locale.warranties');
        $menu_link = route('admin.warranties.index');

        $warranty = $warrantyService->find($request->id);
        return view('Admin.SubViews.Warranty.show', [
            'warranty' => $warranty,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }
}
