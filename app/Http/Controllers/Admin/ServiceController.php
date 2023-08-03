<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Requests\Admin\ServiceRequestEdit;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Services\CategoryService;
use App\Services\PaymentMethodService;
use App\Services\ProviderService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceController extends Controller
{
    public function index(ServiceService $serviceService)
    {
        $services = $serviceService->all();
        $title = __('locale.services');
        $model = 'Service';
        $addRoute = route('admin.services.add');
        $deleteRoute = route('admin.services.delete');

        return view('Admin.SubViews.Service.index', [
            'services' => $services,
            'title' => $title,
            'model' => $model,
            'addRoute' => $addRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, ServiceService $serviceService)
    {
        $page = 'معلومات الخدمة';
        $menu = __('locale.services');
        $menu_link = route('admin.services.index');

        $service = $serviceService->find($request->id);
        return view('Admin.SubViews.Service.show', [
            'service' => $service,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function showAdd(ProviderService $providerService, CategoryService $categoryService, PaymentMethodService $paymentMethodService)
    {
        $page = 'إضافة خدمة';
        $menu = __('locale.services');
        $menu_link = route('admin.services.index');

        return view('Admin.SubViews.Service.add', [
            'providers' => $providerService->all(0),
            'categories' => $categoryService->all(0),
            'paymentMethods' => $paymentMethodService->all(0),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function add(ServiceRequest $request, ServiceService $serviceService)
    {
        $service = $serviceService->add($request->all(), $request->provider_id);
        if ($service) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $service);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, ServiceService $serviceService, ProviderService $providerService, CategoryService $categoryService, PaymentMethodService $paymentMethodService)
    {
        $page = 'تعديل خدمة';
        $menu = __('locale.services');
        $menu_link = route('admin.services.index');

        $service = $serviceService->find($request->id);
        return view('Admin.SubViews.Service.edit', [
            'service' => $service,
            'providers' => $providerService->all(0),
            'paymentMethods' => $paymentMethodService->all(0),
            'categories' => $categoryService->all(0),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }

    public function edit(ServiceRequestEdit $request, ServiceService $serviceService)
    {
        $service = $serviceService->edit($request->all());
        if ($service) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $service);
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
}
