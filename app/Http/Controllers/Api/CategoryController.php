<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SearchRequest;
use App\Http\Resources\CategoryWithServicesResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function details(SearchRequest $request, CategoryService $categoryService)
    {
        $category = $categoryService->details($request->only('id', 'min_price', 'max_price', 'regions'));
        if ($category) {
            $category = CategoryWithServicesResource::make($category);
            return MyHelper::responseJSON(__('api.categoryExists'), 200, $category);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
