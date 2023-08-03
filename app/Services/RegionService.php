<?php

namespace App\Services;

use App\Models\Region;

class RegionService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return Region::withTrashed()->get();
        } else {
            return Region::all();
        }
    }

    public function find($id)
    {
        $region = Region::withTrashed()->find($id);
        $region->ar = [
            'name' => $region->translate('ar')->name,
        ];
        $region->en = [
            'name' => $region->translate('en')->name,
        ];
        return $region;
    }

    public function add($request)
    {
        return Region::create($request);
    }

    public function edit($request)
    {
        $region = Region::withTrashed()->find($request['id']);
        $region->update($request);
        return $region;
    }
}
