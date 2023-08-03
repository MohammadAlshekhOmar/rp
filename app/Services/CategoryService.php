<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function all($name, $withTrashed = 1)
    {
        if ($withTrashed) {
            return Category::with(['media', 'services' => function ($q) {
                $q->with(['orders']);
            }])->withTrashed()->get();
        } else {
            if ($name) {
                return Category::with(['media'])->whereHas('services', function ($q) use ($name) {
                    $q->whereTranslationLike('name', '%' . $name . '%');
                })->get();
            } else {
                return Category::with(['media'])->get();
            }
        }
    }

    public function details($request)
    {
        $category = Category::with(['media', 'services' => function ($q) use ($request) {
            $q->when(isset($request['min_price']), function ($q1) use ($request) {
                return $q1->whereBetween('price', [$request['min_price'], $request['max_price']]);
            })->when(isset($request['regions']), function ($q1) use ($request) {
                return $q1->whereHas('provider', function ($q2) use ($request) {
                    $q2->whereHas('regions', function ($q3) use ($request) {
                        $q3->whereIn('region_id', $request['regions']);
                    });
                });
            });
        }])->find($request['id']);
        return $category;
    }

    public function find($id)
    {
        $category = Category::withTrashed()->with(['media'])->find($id);
        $category->image = $category->image;
        $category->ar = [
            'name' => $category->translate('ar')->name,
            'text' => $category->translate('ar')->text,
        ];
        $category->en = [
            'name' => $category->translate('en')->name,
            'text' => $category->translate('en')->text,
        ];
        return $category;
    }

    public function add($request)
    {
        $category = Category::create($request);
        $category->addMedia($request['image'])->toMediaCollection('Category');
        $category = Category::find($category->id);
        $category->image = $category->image;
        return $category;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $category = Category::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $category->clearMediaCollection('Category');
            $category->addMedia($request['image'])->toMediaCollection('Category');
        }
        $category->update($request);
        $category = Category::withTrashed()->find($category->id);
        $category->image = $category->image;
        DB::commit();
        return $category;
    }
}
