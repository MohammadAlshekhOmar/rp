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
        <a href="{{ route('admin.admins.showAdd') }}" class="btn btn-relief-primary mb-2">
            <span>إضافة</span>
            <i data-feather="plus" class="me-25"></i>
        </a>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr id="sid{{ $admin->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $admin->id }}</span>
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>
                                            @if ($admin->roles()->count())
                                                {{ $admin->roles()->first()->name }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                        @if ($admin->id != 1)
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="form-check form-switch form-check-primary">
                                                        <input type="checkbox" class="form-check-input" name="changeStatus"
                                                            id="{{ $admin->id }}"
                                                            {{ $admin->deleted_at ? null : 'checked=checked' }} />
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $admin->created_at }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.admins.showEdit', ['id' => $admin->id]) }}"
                                                data-bs-toggle="tooltip" title="" data-bs-animation="false"
                                                data-bs-original-title="تعديل">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                                    height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </a>
                                            @if ($admin->id != 1)
                                                <a href="javascript:;" class="btnDelete" id={{ $admin->id }}
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
                            media: 1,
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
