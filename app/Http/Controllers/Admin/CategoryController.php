<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\CategoryRequestEdit;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        $categories = $categoryService->all(null);
        $title = __('locale.categories');
        $model = 'Category';
        $findRoute = route('admin.categories.find');
        $addRoute = route('admin.categories.add');
        $editRoute = route('admin.categories.edit');
        $deleteRoute = route('admin.categories.delete');

        return view('Admin.SubViews.Category.index', [
            'categories' => $categories,
            'title' => $title,
            'model' => $model,
            'findRoute' => $findRoute,
            'addRoute' => $addRoute,
            'editRoute' => $editRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function find(Request $request, CategoryService $categoryService)
    {
        $region = $categoryService->find($request->id);
        if ($region) {
            return MyHelper::responseJSON('تم جلب المعلومات بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function add(CategoryRequest $request, CategoryService $categoryService)
    {
        $region = $categoryService->add($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function edit(CategoryRequestEdit $request, CategoryService $categoryService)
    {
        $region = $categoryService->edit($request->all());
        if ($region) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $region);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
