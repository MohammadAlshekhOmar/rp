@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('vendor-style')
    <!-- vendor css files -->
    <link href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}" rel="stylesheet">

    <style>
        output {
            width: 100%;
            min-height: 150px;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
            border-radius: 5px;
        }

        output .image {
            height: 150px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
        }

        output .image img {
            height: 100%;
            width: 100%;
        }

        output .image span {
            position: absolute;
            top: -4px;
            right: 4px;
            cursor: pointer;
            font-size: 22px;
            color: white;
        }

        output .image span:hover {
            opacity: 0.8;
        }

        output .span--hidden {
            visibility: hidden;
        }
    </style>
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
                <input type="hidden" name="id" value="{{ $provider->id }}">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">الأسم</label>
                                <input type="text" class="form-control" name="name" placeholder="أدخل الأسم"
                                    value="{{ $provider->name }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="text" name="email" class="form-control dt-email"
                                    placeholder="أدخل البريد الإلكتروني" value="{{ $provider->email }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="number" class="form-control" name="phone" value="{{ $provider->phone }}"
                                    placeholder="أدخل رقم الهاتف" />
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
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">الوصف</label>
                                <input type="text" class="form-control" name="text" placeholder="أدخل الوصف"
                                    value="{{ $provider->text }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">رقم السجل التجاري</label>
                                <input type="number" class="form-control" name="commercial_register"
                                    placeholder="أدخل رقم السجل التجاري" value="{{ $provider->commercial_register }}" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">الرقم الضريبي</label>
                                <input type="number" class="form-control" name="tax_number"
                                    placeholder="أدخل الرقم الضريبي" value="{{ $provider->tax_number }}" />
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
                                        <option {{ $language->id == $provider->language_id ? 'selected' : null }}
                                            value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">المناطق</label>
                                <select class="select2 form-control" name="regions[]" multiple>
                                    <option value="" disabled>أختر منطقة</option>

                                    @foreach ($regions as $region)
                                        <option
                                            {{ in_array($region->id,$provider->regions()->get('region_id')->pluck('region_id')->toArray())? 'selected': null }}
                                            value="{{ $region->id }}">{{ $region->name }}</option>
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
                            <img id="show_image" src="{{ $provider->image }}"
                                style="width:200px;height:200px;margin:20px;" alt="provider image" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">الأعمال السابقة</label>
                                <input type="file" class="form-control" id="previous_jobs" name="previous_jobs[]"
                                    multiple />
                            </div>
                            <output></output>
                        </div>
                    </div>
                    <output>
                        <div class="row">
                            @foreach ($provider->previous_jobs as $image)
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <div class="image">
                                        @php
                                            $array = explode('/', $image);
                                            $id = $array[count($array) - 2];
                                        @endphp
                                        <img src="{{ $image }}" alt="previous jobs image">
                                        <span onclick="deleteExistsImage({{ $id }})">&times;</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </output>
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
                show_image.src = URL.createObjectURL(file)
            }
        }

        const images = document.getElementById("previous_jobs")
        const output = document.querySelector("output")
        let imagesArray = []

        images.addEventListener("change", () => {
            const files = images.files
            for (let i = 0; i < files.length; i++) {
                imagesArray.push(files[i])
            }
            displayImages()
        })

        function displayImages() {
            let images = "<div class='row'>"
            imagesArray.forEach((image, index) => {
                images += `<div class="col-md-3 col-sm-6 mb-2">
                                <div class="image">
                                    <img src="${URL.createObjectURL(image)}" alt="previous jobs image">
                                    <span onclick="deleteImage(${index})">&times;</span>
                                </div>
                            </div>`
            })
            images += "</div>";
            output.innerHTML = images
        }

        function deleteImage(index) {
            imagesArray.splice(index, 1)
            displayImages()
        }

        function deleteExistsImage(id) {
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

                    $.ajax({
                        url: "{{ route('admin.providers.delete.image') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                        },
                        success: function(response, textStatus, xhr) {
                            window.location.reload();
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $("#frmSubmit").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.providers.edit') }}",
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
