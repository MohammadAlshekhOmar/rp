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
                                            <h5 class="mb-75" style="font-weight:bold;">اسم المستخدم</h5>
                                            <p class="card-text">{{ $invoice->order?->user?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">اسم الشركة</h5>
                                            <p class="card-text">{{ $invoice->order?->service?->provider?->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">اسم الخدمة</h5>
                                            <p class="card-text">{{ $invoice->order?->service?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">رسوم الخدمة</h5>
                                            <p class="card-text">{{ $invoice->order?->service?->price }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">التخفيض</h5>
                                            <p class="card-text">{{ $invoice->discount . '%' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">المجموع</h5>
                                            <p class="card-text">
                                                {{ ($invoice->order?->service?->price * $invoice->discount) / 100 }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">رقم الفاتورة</h5>
                                            <p class="card-text">{{ $invoice->number }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">فترة الضمان</h5>
                                            <p class="card-text">{{ $invoice->warranty_period . ' يوم' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">حالة الفاتورة</h5>
                                            <p class="card-text">حالة الفاتورة</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ الفاتورة</h5>
                                            <p class="badge rounded-pill badge-light-secondary">{{ $invoice->created_at }}
                                            </p>
                                        </div>
                                    </div>
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
