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
                            <img src="{{ $provider->image }}" alt="user image"
                                style="height:150px;width:150px;border-radius:100%;margin:15px auto;" />
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الأسم</h5>
                                            <p class="card-text">{{ $provider->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">البريد الإلكتروني</h5>
                                            <p class="card-text">{{ $provider->email }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">رقم الهاتف</h5>
                                            <p class="card-text">{{ $provider->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">اللغة</h5>
                                            <p class="card-text">{{ $provider->language->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">المناطق</h5>
                                            @foreach ($provider->regions as $region)
                                                <p class="badge rounded-pill badge-light-info">{{ $region->region->name }}
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">رقم السجل التجاري</h5>
                                            <p class="card-text">{{ $provider->commercial_register }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الرقم الضريبي</h5>
                                            <p class="card-text">{{ $provider->tax_number }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الوصف</h5>
                                            <p class="card-text">{{ $provider->text }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ الإنشاء</h5>
                                            <p class="badge rounded-pill badge-light-secondary">{{ $provider->created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    @foreach ($provider->previous_jobs as $previous_job)
                                        <div class="col-md-3 col-sm-6 mb-2">
                                            <img src="{{ $previous_job }}" alt="previous job"
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
