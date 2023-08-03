<?php

namespace App\Services;

use App\Enums\DeleteActionEnum;

class DeleteService
{
    public function delete($model, $id, $operation, $media, $withTrashed)
    {
        $model = 'App\Models\\' . $model;
        if ($withTrashed) {
            $model = $model::withTrashed()->find($id);
        } else {
            $model = $model::find($id);
        }

        if ($model) {
            if ($operation == DeleteActionEnum::SOFT_DELETE->value) {
                $model->delete();
            } else if ($operation == DeleteActionEnum::RESTORE_DELETE->value) {
                $model->restore();
            } else if ($operation == DeleteActionEnum::FORCE_DELETE->value) { // force delete
                if ($media) {
                    $model->clearMediaCollection($model);
                }
                $model->forceDelete();
            }
            return $model;
        } else {
            return NULL;
        }
    }
}
