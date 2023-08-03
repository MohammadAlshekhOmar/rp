@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="modal-header" style="display:grid;">
                <h5 class="modal-title"></h5>
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.cp') }}">الرئيسية</a>
                                </li>
                                @if (isset($menu))
                                    <li class="breadcrumb-item"><a href="{{ $menu_link }}">{{ $menu }}</a>
                                    </li>
                                @endif
                                <li class="breadcrumb-item active">{{ $page }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الأسم بالعربي</h5>
                                            <p class="card-text">{{ $service->translate('ar')->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الأسم بالأجنبي</h5>
                                            <p class="card-text">{{ $service->translate('en')->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الوصف بالعربي</h5>
                                            <p class="card-text">{{ $service->translate('ar')->text }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الوصف بالأجنبي</h5>
                                            <p class="card-text">{{ $service->translate('en')->text }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">مزود الخدمة</h5>
                                            <p class="card-text">{{ $service->provider?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">رسوم الخدمة</h5>
                                            <p class="card-text">{{ $service->price }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تصنيف</h5>
                                            <p class="card-text">{{ $service->category?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">طريقة الدفع</h5>
                                            <p class="card-text">{{ $service->payment_method?->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">لديه تفاصيل</h5>
                                            <p class="card-text">{{ $service->has_detail == 1 ? 'نعم' : 'لا' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ الإنشاء</h5>
                                            <p class="badge rounded-pill badge-light-secondary">{{ $service->created_at }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    @foreach ($service->images as $image)
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <img src="{{ $image }}" alt="service job"
                                                style="width:150px;height:150px;border-radius:10px;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="float:right;">
            </div>
        </div>
    </div>
@endsection
