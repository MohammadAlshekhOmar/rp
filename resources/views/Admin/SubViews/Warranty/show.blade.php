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
                                            <p class="card-text">{{ $warranty->invoice?->order?->user?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">اسم الشركة</h5>
                                            <p class="card-text">
                                                {{ $warranty->invoice?->order?->service?->provider?->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">اسم الخدمة</h5>
                                            <p class="card-text">{{ $warranty->invoice?->order?->service?->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">قيمة القعد</h5>
                                            <p class="card-text">{{ $warranty->contract_value }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ القعد</h5>
                                            <p class="card-text">{{ $warranty->contract_date }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ إنتهاء الضمان</h5>
                                            <p class="card-text">{{ $warranty->expiry_date }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">تاريخ الإنشاء</h5>
                                            <p class="badge rounded-pill badge-light-secondary">{{ $warranty->created_at }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            @if ($warranty->getFirstMediaUrl('Warranty'))
                                                <a href="{{ $warranty->getFirstMediaUrl('Warranty') }}" target="_blank"
                                                    data-bs-toggle="tooltip" title="" data-bs-animation="false"
                                                    data-bs-original-title="PDF">
                                                    <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-download-cloud">
                                                        <polyline points="8 17 12 21 16 17"></polyline>
                                                        <line x1="12" y1="12" x2="12" y2="21">
                                                        </line>
                                                        <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif
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
