@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endsection

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
                                            <h5 class="mb-75" style="font-weight:bold;">العنوان بالعربي</h5>
                                            <p class="card-text">{{ $notification->translate('ar')->title }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">العنوان بالأجنبي</h5>
                                            <p class="card-text">{{ $notification->translate('en')->title }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الوصف بالعربي</h5>
                                            <p class="card-text">{{ $notification->translate('ar')->text }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <h5 class="mb-75" style="font-weight:bold;">الوصف بالأجنبي</h5>
                                            <p class="card-text">{{ $notification->translate('en')->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($notification->users) > 0)
                            <div class="card">
                                <div class="card-header">
                                    المستخدمين
                                </div>
                                <div class="card-body text-center">
                                    <div class="table-responsive text-center">
                                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الأسم</th>
                                                    <th>البريد الإلكتروني</th>
                                                    <th>رقم الهاتف</th>
                                                    <th>تاريخ الإنشاء</th>
                                                    <th>النشاط</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notification->users as $user)
                                                    <tr>
                                                        <td><span
                                                                class="badge rounded-pill badge-light-primary">{{ $user->id }}</span>
                                                        </td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td><span
                                                                class="badge rounded-pill badge-light-secondary">{{ $user->created_at }}</span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.users.show', ['id' => $user->id]) }}"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-animation="false" data-bs-original-title="عرض">
                                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg"
                                                                    width="14" height="14" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-eye">
                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                    </path>
                                                                    <circle cx="12" cy="12" r="3">
                                                                    </circle>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (count($notification->providers) > 0)
                            <div class="card">
                                <div class="card-header">
                                    مزودين الخدمة
                                </div>
                                <div class="card-body text-center">
                                    <div class="table-responsive text-center">
                                        <table class="table table-striped table-head-custom table-checkable" id="dtTable1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الأسم</th>
                                                    <th>البريد الإلكتروني</th>
                                                    <th>رقم الهاتف</th>
                                                    <th>تاريخ الإنشاء</th>
                                                    <th>النشاط</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notification->providers as $provider)
                                                    <tr>
                                                        <td><span
                                                                class="badge rounded-pill badge-light-primary">{{ $provider->id }}</span>
                                                        </td>
                                                        <td>{{ $provider->name }}</td>
                                                        <td>{{ $provider->email }}</td>
                                                        <td>{{ $provider->phone }}</td>
                                                        <td><span
                                                                class="badge rounded-pill badge-light-secondary">{{ $provider->created_at }}</span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.providers.show', ['id' => $provider->id]) }}"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-animation="false" data-bs-original-title="عرض">
                                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg"
                                                                    width="14" height="14" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-eye">
                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                    </path>
                                                                    <circle cx="12" cy="12" r="3">
                                                                    </circle>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="float:right;">
        </div>
    </div>
    </div>
@endsection

@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset('js/scripts/tables/table-datatables-advanced.js') }}"></script>
    @if (session()->get('locale') == 'en')
        <script src="{{ asset('js/scripts/tables/datatable_en.js') }}"></script>
    @else
        <script src="{{ asset('js/scripts/tables/datatable.js') }}"></script>
    @endif
@endsection
