<?php

namespace App\Services;

use App\Models\Language;

class LanguageService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return Language::withTrashed()->get();
        } else {
            return Language::all();
        }
    }

    public function find($id)
    {
        $language = Language::withTrashed()->find($id);
        $language->ar = [
            'name' => $language->translate('ar')->name
        ];
        $language->en = [
            'name' => $language->translate('en')->name
        ];
        return $language;
    }

    public function add($request)
    {
        return Language::create($request);
    }

    public function edit($request)
    {
        $language = Language::withTrashed()->find($request['id']);
        $language->update($request);
        return $language;
    }
}
