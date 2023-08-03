@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <button type="button" class="btn btn-relief-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
            <span>إضافة</span>
            <i data-feather="plus" class="me-25"></i>
        </button>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأسم</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody id="add-row">
                                @foreach ($regions as $region)
                                    <tr id="sid{{ $region->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $region->id }}</span>
                                        </td>
                                        <td>{{ $region->name }}</td>
                                        <td>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="form-check form-switch form-check-primary">
                                                    <input type="checkbox" class="form-check-input" name="changeStatus"
                                                        id="{{ $region->id }}"
                                                        {{ $region->deleted_at ? null : 'checked=checked' }} />
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $region->created_at }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-bs-toggle="tooltip"
                                                data-bs-animation="false" data-bs-original-title="تعديل" title="تعديل"
                                                id="edit-button" data-id="{{ $region->id }}">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                                    height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <a href="javascript:;" class="btnDelete" id={{ $region->id }}
                                                data-bs-toggle="tooltip" data-bs-animation="false"
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

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content pt-0" id="addForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">إضافة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="ar-tab-add" data-bs-toggle="tab" href="#ar-add"
                                            aria-controls="ar-add" role="tab" aria-selected="true"><i
                                                data-feather="flag"></i>
                                            AR</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="en-tab-add" data-bs-toggle="tab" href="#en-add"
                                            aria-controls="en-add" role="tab" aria-selected="false"><i
                                                data-feather="flag"></i>EN</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="ar-add" aria-labelledby="ar-tab-add"
                                        role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label">الأسم</label>
                                                    <input type="text" class="form-control" name="ar[name]"
                                                        placeholder="أدخل الأسم" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="en-add" aria-labelledby="en-tab-add" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label">الأسم</label>
                                                    <input type="text" class="form-control" name="en[name]"
                                                        placeholder="أدخل الأسم" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-relief-secondary" data-bs-dismiss="modal">
                            <span>إلغاء</span>
                            <i data-feather="x"></i>
                        </button>
                        <button type="submit" class="btn btn-relief-primary submitFrom">
                            <span>حفظ</span>
                            <i data-feather="check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content pt-0" id="editForm">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">تعديل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="ar-tab-edit" data-bs-toggle="tab" href="#ar-edit"
                                            aria-controls="ar-edit" role="tab" aria-selected="true"><i
                                                data-feather="flag"></i>
                                            AR</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="en-tab-edit" data-bs-toggle="tab" href="#en-edit"
                                            aria-controls="en-edit" role="tab" aria-selected="false"><i
                                                data-feather="flag"></i>EN</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="ar-edit" aria-labelledby="ar-tab-edit"
                                        role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label">الأسم</label>
                                                    <input type="text" class="form-control" name="ar[name]"
                                                        placeholder="أدخل الأسم" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="en-edit" aria-labelledby="en-tab-edit" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-1">
                                                    <label class="form-label">الأسم</label>
                                                    <input type="text" class="form-control" name="en[name]"
                                                        placeholder="أدخل الأسم" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-relief-secondary" data-bs-dismiss="modal">
                            <span>إلغاء</span>
                            <i data-feather="x"></i>
                        </button>
                        <button type="submit" class="btn btn-relief-primary submitFrom">
                            <span>تعديل</span>
                            <i data-feather="check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
    @if (session()->get('locale') == 'en')
        <script src="{{ asset(mix('js/scripts/tables/datatable_en.js')) }}"></script>
    @else
        <script src="{{ asset(mix('js/scripts/tables/datatable.js')) }}"></script>
    @endif

    <script>
        let editButton;

        $("#editModal").on("hidden.bs.modal", function() {
            $("[name='ar[name]']").val('');
            $("[name='en[name]']").val('');
        });

        $(document).on("click", "#edit-button", function() {
            editButton = $(this).data('id');
        });

        $('#editModal').on('shown.bs.modal', function() {
            $.ajax({
                url: '{{ $findRoute }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: editButton
                },
                success: function(response, textStatus, xhr) {
                    $("[name='id']").val(response.data.id);
                    $("[name='ar[name]']").val(response.data.ar.name);
                    $("[name='en[name]']").val(response.data.en.name);
                },
                error: function(response) {
                    alert(response.data);
                }
            });
        });

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

        $(document).on('submit', '#addForm', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ $addRoute }}',
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#listError').empty();
                    $("#alertError").hide();
                    $("#alertSuccess").hide();
                    $(".submitFrom span").html('جاري الإرسال');
                    $('.submitFrom').prop('disabled', true);
                },
                success: function(response, textStatus, xhr) {
                    $('#addModal').modal('hide');
                    $("[name='ar[name]']").val('');
                    $("[name='en[name]']").val('');

                    if (xhr.status == 201) {

                        $('#add-row').prepend(`
                            <tr id="sid${response.data.id}">
                                <td><span class="badge rounded-pill badge-light-primary">${response.data.id}</span></td>
                                <td>${response.data.name}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="form-check form-switch form-check-primary">
                                            <input type="checkbox" class="form-check-input" name="changeStatus"
                                                id="${response.data.id}" checked="checked" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill badge-light-secondary">${response.data.created_at}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-bs-toggle="tooltip" data-bs-animation="false"
                                        data-bs-original-title="تعديل" title="تعديل" id="edit-button"
                                        data-id="${response.data.id}">
                                        <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                            </path>
                                        </svg>
                                    </button>
                                    <a href="javascript:;" class="btnDelete" id=${response.data.id}
                                        data-bs-toggle="tooltip" data-bs-animation="false"
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
                        `);

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
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                },
                error: function(response) {
                    $('#addModal').modal('hide');

                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك',
                            'لا يمكنك القيام بهذه العملية', 'error');
                    } else {
                        $("#alertError").show();

                        if (response.status == 500) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(response.responseJSON
                                .message));
                            ul.appendChild(li);
                        }

                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(errors[error]));
                            ul.appendChild(li);
                        }
                    }
                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                }
            });
        });

        $(document).on('submit', '#editForm', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ $editRoute }}',
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#listError').empty();
                    $("#alertError").hide();
                    $("#alertSuccess").hide();
                    $(".submitFrom span").html('جاري الإرسال');
                    $('.submitFrom').prop('disabled', true);
                },
                success: function(response, textStatus, xhr) {
                    $('#editModal').modal('hide');
                    $('#sid' + response.data.id).find("td").eq(1).html(response.data.name);

                    if (xhr.status == 200) {
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
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                },
                error: function(response) {
                    $('#editModal').modal('hide');

                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك',
                            'لا يمكنك القيام بهذه العملية', 'error');
                    } else {
                        $("#alertError").show();

                        if (response.status == 500) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(response.responseJSON
                                .message));
                            ul.appendChild(li);
                        }

                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(errors[error]));
                            ul.appendChild(li);
                        }
                    }
                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
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
