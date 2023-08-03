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
        <a href="{{ route('admin.roles.showAdd') }}" class="btn btn-relief-primary mb-2">
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
                                    <th>الصلاحيات</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr id="sid{{ $role->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $role->id }}</span>
                                        </td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $permission)
                                                <span
                                                    class="badge rounded-pill badge-light-info">{{ $permission->name_ar }}</span>
                                            @endforeach
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $role->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.roles.showEdit', ['id' => $role->id]) }}"
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
                                            <a href="javascript:;" class="btnDelete" id={{ $role->id }}
                                                data-bs-toggle="tooltip" title="" data-bs-animation="false"
                                                data-bs-original-title="حذف">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                                    height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash">
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
        $(document).on('click', '.btnDelete', function() {
            Swal.fire({
                title: 'هل أنت متأكد من عملية الحذف؟',
                text: "لن تتمكن من استرجاعه!",
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
                        url: "{{ route('admin.roles.delete') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: currentId
                        },
                        success: function(response, textStatus, xhr) {
                            if (xhr.status == 200) {
                                $('#sid' + currentId).remove();
                                $("#alertError").hide();
                                $("#alertSuccess").show();
                                $('#successMessage').html(response["message"]);
                            } else {
                                $("#alertSuccess").hide();
                                $("#alertError").show();
                                $('#errorMessage').html(response["message"]);
                            }

                            $("html, body").animate({
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
