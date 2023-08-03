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
                                    <th>حالة الطلب</th>
                                    <th>رقم الفاتورة</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الطلب</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr id="sid{{ $order->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $order->id }}</span>
                                        </td>
                                        <td>{{ $order->user?->name }}</td>
                                        <td>{{ $order->provider?->name }}</td>
                                        <td>{{ $order->service?->name }}</td>
                                        <td>{{ $order->order_status?->name }}</td>
                                        <td>{{ $order->invoice_id ?? 'لا يوجد' }}</td>
                                        <td>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="form-check form-switch form-check-primary">
                                                    <input type="checkbox" class="form-check-input" name="changeStatus"
                                                        id="{{ $order->id }}"
                                                        {{ $order->deleted_at ? null : 'checked=checked' }} />
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $order->created_at }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}"
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
                                            <a href="javascript:;" class="btnDelete" id={{ $order->id }}
                                                data-bs-toggle="tooltip" title="" data-bs-animation="false"
                                                data-bs-original-title="حذف">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg"
                                                    width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-trash">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
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

    <script>
        $(document).on('change', 'input[type=checkbox][name=changeStatus]', function() {
            if (!$(this).is(':checked')) {
                $(this).removeAttr('checked');
            } else {
                $(this).attr('checked', 'checked');
            }

            var restore = "{{ App\Enums\DeleteActionEnum::RESTORE_DELETE->value }}";
            var soft = "{{ App\Enums\DeleteActionEnum::SOFT_DELETE->value }}";

            currentId = $(this).attr('id');
            operation = $(this).is(':checked') === true ? restore : soft

            $.ajax({
                url: '{{ $deleteRoute }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    model: '{{ $model }}',
                    id: currentId,
                    operation: operation,
                    withTrashed: 1
                },
                success: function(response, textStatus, xhr) {
                    if (xhr.status == 200) {
                        $('#alertError').hide();
                        $('#alertSuccess').show();
                        $('#successMessage').html(response['message']);
                    } else {
                        $('#alertSuccess').hide();
                        $('#alertError').show();
                        $('#errorMessage').html(response['message']);
                    }

                    $('html, body').animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                },
                error: function(response) {
                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك', 'لا يمكنك القيام بهذه العملية',
                            'error');
                    }
                }
            });
        });

        $(document).on('click', '.btnDelete', function() {
            Swal.fire({
                title: 'هل أنت متأكد من عملية الحذف؟',
                text: 'لن تتمكن من استرجاعه!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم, حذف',
                cancelButtonText: 'لا, إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).prop('disabled', true);
                    currentId = $(this).attr('id');

                    $.ajax({
                        url: '{{ $deleteRoute }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            model: '{{ $model }}',
                            id: currentId,
                            operation: "{{ App\Enums\DeleteActionEnum::FORCE_DELETE->value }}",
                            media: 0,
                            withTrashed: 1
                        },
                        success: function(response, textStatus, xhr) {
                            if (xhr.status == 200) {
                                $('#sid' + currentId).remove();
                                $('#alertError').hide();
                                $('#alertSuccess').show();
                                $('#successMessage').html(response['message']);
                            } else {
                                $('#alertSuccess').hide();
                                $('#alertError').show();
                                $('#errorMessage').html(response['message']);
                            }

                            $('html, body').animate({
                                scrollTop: 0
                            }, {
                                duration: 1500,
                            });

                            fireMessage('حسناً');
                        },
                        error: function(response) {
                            if (response.status == 401 || response.status == 403) {
                                fireMessage('حسناً', 'غير مصرح بك',
                                    'لا يمكنك القيام بهذه العملية', 'error');
                            }
                        }
                    });
                }
            });
        });
    </script>

@endsection
