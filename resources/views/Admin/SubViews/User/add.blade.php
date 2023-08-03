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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">الأسم</label>
                                <input type="text" class="form-control" name="name" placeholder="أدخل الأسم" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="text" name="email" class="form-control dt-email"
                                    placeholder="أدخل البريد الإلكتروني" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="number" class="form-control" name="phone" placeholder="أدخل رقم الهاتف" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="أدخل كلمة المرور" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="أدخل تأكيد كلمة المرور" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">اللغة</label>
                                <select class="form-control" name="language_id">
                                    <option value="" disabled>أختر لغة</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">المناطق</label>
                                <select class="select2 form-control" name="region_id">
                                    <option value="" disabled>أختر منطقة</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">الصورة</label>
                                <input type="file" class="form-control" id="image" name="image" />
                            </div>
                            <img id="show_image" src="#" style="display:none;width:200px;height:200px;margin:20px;"
                                alt="user image" />
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

        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                document.getElementById("show_image").style.display = "block";
                show_image.src = URL.createObjectURL(file)
            }
        }

        $(document).ready(function() {
            $("#frmSubmit").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.users.add') }}",
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
        });
    </script>

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
