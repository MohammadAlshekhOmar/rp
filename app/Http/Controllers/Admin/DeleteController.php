<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\MyHelper;
use App\Services\DeleteService;
use App\Enums\DeleteActionEnum;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Request $request, DeleteService $deleteService)
    {
        $model = $deleteService->delete($request->model, $request->id, $request->operation, $request->media, $request->withTrashed);
        if ($model) {
            if ($request->operation == DeleteActionEnum::SOFT_DELETE->value) {
                return MyHelper::responseJSON('تم إلغاء التفعيل بنجاح', 200, $model);
            } else if ($request->operation == DeleteActionEnum::RESTORE_DELETE->value) {
                return MyHelper::responseJSON('تم التفعيل بنجاح', 200, $model);
            } else {
                return MyHelper::responseJSON('تم الحذف بنجاح', 200, $model);
            }
        } else {
            return MyHelper::responseJSON('لا يوجد بيانات', 400);
        }
    }
}
