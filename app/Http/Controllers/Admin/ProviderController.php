<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProviderRequest;
use App\Http\Requests\Admin\ProviderRequestEdit;
use App\Services\ProviderService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Exports\ProvidersExport;
use App\Services\RegionService;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProviderController extends Controller
{
    public function index(ProviderService $providerService)
    {
        $providers = $providerService->all();
        $title = __('locale.providers');
        $model = 'Provider';
        $addRoute = route('admin.providers.add');
        $deleteRoute = route('admin.providers.delete');

        return view('Admin.SubViews.Provider.index', [
            'providers' => $providers,
            'title' => $title,
            'model' => $model,
            'addRoute' => $addRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, ProviderService $providerService)
    {
        $page = 'معلومات مزود الخدمة';
        $menu = __('locale.providers');
        $menu_link = route('admin.providers.index');

        $provider = $providerService->find($request->id);
        return view('Admin.SubViews.Provider.show', [
            'provider' => $provider,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function showAdd(LanguageService $languageService, RegionService $regionService)
    {
        $page = 'إضافة مزود خدمة';
        $menu = __('locale.providers');
        $menu_link = route('admin.providers.index');

        return view('Admin.SubViews.Provider.add', [
            'languages' => $languageService->all(),
            'regions' => $regionService->all(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(ProviderRequest $request, ProviderService $providerService)
    {
        $provider = $providerService->add($request->all());
        if ($provider) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $provider);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, ProviderService $providerService, LanguageService $languageService, RegionService $regionService)
    {
        $page = 'تعديل مزود خدمة';
        $menu = __('locale.providers');
        $menu_link = route('admin.providers.index');

        $provider = $providerService->find($request->id);
        return view('Admin.SubViews.Provider.edit', [
            'provider' => $provider,
            'languages' => $languageService->all(),
            'regions' => $regionService->all(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function edit(ProviderRequestEdit $request, ProviderService $providerService)
    {
        $provider = $providerService->edit($request->all());
        if ($provider) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $provider);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function deleteImage(Request $request)
    {
        $media = Media::find($request->id);
        $media->delete();
        return TRUE;
    }

    public function export()
    {
        return Excel::download(new ProvidersExport, 'Providers.xlsx');
    }
}
