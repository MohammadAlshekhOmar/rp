@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('vendor-style')
    <!-- vendor css files -->
    <link href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}" rel="stylesheet">
@endsection

@section('content')

    <div class="row breadcrumbs-top mb-2">
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

    <div class="row">
        <div class="col-12">
            <form class="add-new-record modal-content pt-0" id="frmSubmit">
                @csrf
                <div class="modal-header" style="display:grid;">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="row" id="users">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">المستخدمين</label>
                                <select class="select2 form-control" name="users[]" multiple>
                                    <option value="all">الكل</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="providers">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">مزودين الخدمة</label>
                                <select class="select2 form-control" name="providers[]" multiple>
                                    <option value="all">الكل</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="ar-tab" data-bs-toggle="tab" href="#ar"
                                        aria-controls="ar" role="tab" aria-selected="true"><i data-feather="flag"></i>
                                        AR</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="en-tab" data-bs-toggle="tab" href="#en"
                                        aria-controls="en" role="tab" aria-selected="false"><i
                                            data-feather="flag"></i>EN</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="ar" aria-labelledby="ar-tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">العنوان</label>
                                                <input type="text" class="form-control" name="title_ar"
                                                    placeholder="أدخل العنوان" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">الوصف</label>
                                                <textarea class="form-control" name="text_ar" style="height:200px;" placeholder="أدخل الوصف"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="en" aria-labelledby="en-tab" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">العنوان</label>
                                                <input type="text" class="form-control" name="title_en"
                                                    placeholder="أدخل العنوان" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">الوصف</label>
                                                <textarea class="form-control" name="text_en" style="height:200px;" placeholder="أدخل الوصف"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding:10px;display:flex;flex-direction:row-reverse;">
                    <button type="submit" class="btn btn-relief-primary submitFrom">
                        <span>حفظ</span>
                        <i data-feather="check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-script')

    <script>
        $(".select2").select2();

        $(document).ready(function() {
            $("#frmSubmit").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.notifications.add') }}",
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
                        if (xhr.status == 201) {
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
                        $("#alertError").show();

                        if (response.status == 401 || response.status == 403) {
                            fireMessage('حسناً', 'غير مصرح بك',
                                'لا يمكنك القيام بهذه العملية', 'error');
                        } else {
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
        });
    </script>

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
