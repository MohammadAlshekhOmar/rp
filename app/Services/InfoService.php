<?php

namespace App\Services;

use App\Models\Info;

class InfoService
{
    public function first()
    {
        return Info::first();
    }

    public function edit($request)
    {
        $info = Info::first();
        $info->update($request);
        return $info;
    }
}
