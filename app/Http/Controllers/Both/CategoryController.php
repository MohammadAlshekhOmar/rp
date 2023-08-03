<?php

namespace App\Http\Controllers\Both;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function all(Request $request, CategoryService $categoryService)
    {
        $categories = $categoryService->all($request->name, 0);
        if ($categories) {
            $categories = CategoryResource::collection($categories);
            return MyHelper::responseJSON(__('api.categoryExists'), 200, $categories);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
