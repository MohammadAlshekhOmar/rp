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
                                    <th>رسوم الخدمة</th>
                                    <th>التخفيض</th>
                                    <th>المجموع</th>
                                    <th>رقم الفاتورة</th>
                                    <th>حالة الفاتورة</th>
                                    <th>فترة الضمان</th>
                                    <th>تاريخ الفاتورة</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr id="sid{{ $invoice->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $invoice->id }}</span>
                                        </td>
                                        <td>{{ $invoice->order?->user?->name }}</td>
                                        <td>{{ $invoice->order?->service?->provider?->name }}</td>
                                        <td>{{ $invoice->order?->service?->name }}</td>
                                        <td>{{ $invoice->order?->service?->price }}</td>
                                        <td>{{ $invoice->discount . '%' }}</td>
                                        <td>{{ ($invoice->order?->service?->price * $invoice->discount) / 100 }}</td>
                                        <td>{{ $invoice->number }}</td>
                                        <td>حالة الفاتورة</td>
                                        <td>{{ $invoice->warranty_period . ' يوم' }}</td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $invoice->created_at }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.invoices.show', ['id' => $invoice->id]) }}"
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
