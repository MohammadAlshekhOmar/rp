@extends('layouts.contentLayoutMaster')

@section('title', 'معلومات الموقع')

@section('vendor-style')
    <style>
        .note-editable {
            background: #FFF;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form class="add-new-record modal-content pt-0" id="frmSubmit">
                @csrf
                <div class="modal-header mb-1">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ar-tab" data-bs-toggle="tab" href="#ar" aria-controls="ar"
                                role="tab" aria-selected="true"><i data-feather="flag"></i>
                                AR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="en-tab" data-bs-toggle="tab" href="#en" aria-controls="en"
                                role="tab" aria-selected="false"><i data-feather="flag"></i>EN</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ar" aria-labelledby="ar-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">معلومات عنا</label>
                                        <input type="hidden" name="ar[about_us][key]"
                                            value="{{ App\Enums\SettingEnum::AboutUs->value }}">
                                        <textarea class="summernote" name="ar[about_us][value]">{{ $settings['about_us']->translate('ar')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">سياسة الخصوصية</label>
                                        <input type="hidden" name="ar[privacy_policy][key]"
                                            value="{{ App\Enums\SettingEnum::PrivacyPolicy->value }}">
                                        <textarea class="summernote" name="ar[privacy_policy][value]">{{ $settings['privacy_policy']->translate('ar')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">الشروط والأحكام</label>
                                        <input type="hidden" name="ar[terms_conditions][key]"
                                            value="{{ App\Enums\SettingEnum::TermsConditions->value }}">
                                        <textarea class="summernote" name="ar[terms_conditions][value]">{{ $settings['terms_conditions']->translate('ar')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">البراند</label>
                                        <input type="hidden" name="ar[brand][key]"
                                            value="{{ App\Enums\SettingEnum::Brand->value }}">
                                        <input type="text" class="form-control" name="ar[brand][value]"
                                            value="{{ $settings['brand']->translate('ar')->value }}"
                                            placeholder="أدخل البراند">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="en" aria-labelledby="en-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">معلومات عنا</label>
                                        <input type="hidden" name="en[about_us][key]"
                                            value="{{ App\Enums\SettingEnum::AboutUs->value }}">
                                        <textarea class="summernote" name="en[about_us][value]" style="height:200px;" placeholder="أدخل معلومات عنا">{{ $settings['about_us']->translate('en')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">سياسة الخصوصية</label>
                                        <input type="hidden" name="en[privacy_policy][key]"
                                            value="{{ App\Enums\SettingEnum::PrivacyPolicy->value }}">
                                        <textarea class="summernote" name="en[privacy_policy][value]">{{ $settings['privacy_policy']->translate('en')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">الشروط والأحكام</label>
                                        <input type="hidden" name="en[terms_conditions][key]"
                                            value="{{ App\Enums\SettingEnum::TermsConditions->value }}">
                                        <textarea class="summernote" name="en[terms_conditions][value]">{{ $settings['terms_conditions']->translate('en')->value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">البراند</label>
                                        <input type="hidden" name="en[brand][key]"
                                            value="{{ App\Enums\SettingEnum::Brand->value }}">
                                        <input type="text" class="form-control" name="en[brand][value]"
                                            value="{{ $settings['brand']->translate('en')->value }}"
                                            placeholder="أدخل البراند">
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

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/lang/summernote-ar-AR.min.js"
        integrity="sha512-uJrAbZZW6Fc2rWFW9bFNkaZdBfNV5b3sS6WeUZ2kn9UCp5MKLBSU10D75O0s6AHYQwtdSckrKzSCBsUVkm4PUQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('.summernote').summernote({
            lang: 'ar-AR',
            placeholder: 'أدخل تنسيق',
            tabsize: 2,
            height: 200
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#frmSubmit").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.settings.edit') }}",
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
                        if (response.status == 401) {
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
