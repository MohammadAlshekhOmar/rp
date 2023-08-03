<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InfoRequest;
use App\Services\InfoService;
use App\Helpers\MyHelper;

class InfoController extends Controller
{
    public function index(InfoService $infoService)
    {
        $title = __('locale.infos');
        $info = $infoService->first();
        return view('Admin.SubViews.Info.index', [
            'title' => $title,
            'info' => $info,
        ]);
    }

    public function edit(InfoRequest $request, InfoService $infoService)
    {
        $info = $infoService->edit($request->all());
        if ($info) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $info);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
