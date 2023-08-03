@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم المستخدم</th>
                                    <th>اسم الشركة</th>
                                    <th>اسم الخدمة</th>
                                    <th>قيمة القعد</th>
                                    <th>تاريخ القعد</th>
                                    <th>تاريخ إنتهاء الضمان</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warranties as $warranty)
                                    <tr id="sid{{ $warranty->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $warranty->id }}</span>
                                        </td>
                                        <td>{{ $warranty->invoice?->order?->user?->name }}</td>
                                        <td>{{ $warranty->invoice?->order?->service?->provider?->name }}</td>
                                        <td>{{ $warranty->invoice?->order?->service?->name }}</td>
                                        <td>{{ $warranty->contract_value }}</td>
                                        <td>{{ $warranty->contract_date }}</td>
                                        <td>{{ $warranty->expiry_date }}</td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $warranty->created_at }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.warranties.show', ['id' => $warranty->id]) }}"
                                                data-bs-toggle="tooltip" title="" data-bs-animation="false"
                                                data-bs-original-title="عرض">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-eye">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Basic table -->
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
