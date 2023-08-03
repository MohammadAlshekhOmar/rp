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
                <div class="modal-header" style="display:grid;">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ar-tab-add" data-bs-toggle="tab" href="#ar-add"
                                aria-controls="ar-add" role="tab" aria-selected="true"><i data-feather="flag"></i>
                                AR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="en-tab-add" data-bs-toggle="tab" href="#en-add" aria-controls="en-add"
                                role="tab" aria-selected="false"><i data-feather="flag"></i>EN</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="ar-add" aria-labelledby="ar-tab-add" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">الأسم</label>
                                        <input type="text" class="form-control" name="ar[name]"
                                            placeholder="أدخل الأسم" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="ar[text]" class="form-control" cols="30" rows="10" placeholder="أدخل الوصف"></textarea>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label class="form-label">الوصف</label>
                                        <textarea name="en[text]" class="form-control" cols="30" rows="10" placeholder="أدخل الوصف"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">مزودين الخدمة</label>
                                <select class="select2 form-control" name="provider_id">
                                    <option value="" disabled>أختر مزود خدمة</option>
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">رسوم الخدمة</label>
                                <input type="number" class="form-control" name="price" placeholder="أدخل رسوم الخدمة" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">التصنيفات</label>
                                <select class="select2 form-control" name="category_id">
                                    <option value="" disabled>أختر تصنيف</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label class="form-label">طرق الدفع</label>
                                <select class="select2 form-control" name="payment_method_id">
                                    <option value="" disabled>أختر طريقة دفع</option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                        name="has_detail">
                                    <label class="form-check-label" for="inlineCheckbox1">لديه تفاصيل</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label class="form-label">الصور</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple />
                            </div>
                            <p id="files-area">
                                <span id="filesList">
                                    <span id="files-names"></span>

                                </span>
                            </p>

                            <output></output>
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
        const dt = new DataTransfer();

        $("#images").on('change', function(e) {
            for (var i = 0; i < this.files.length; i++) {
                let fileBloc = $('<span/>', {
                        class: 'file-block',
                        style: 'margin:10px;padding:10px;border: 1px solid;border-radius:10px'
                    }),
                    fileName = $('<span/>', {
                        class: 'name',
                        text: this.files.item(i).name
                    });
                fileBloc.append('<span class="file-delete"><span>&times;</span></span>')
                    .append(fileName);
                $("#filesList > #files-names").append(fileBloc);
            };
            for (let file of this.files) {
                dt.items.add(file);
            }
            this.files = dt.files;

            $('span.file-delete').click(function() {
                let name = $(this).next('span.name').text();
                $(this).parent().remove();
                for (let i = 0; i < dt.items.length; i++) {
                    if (name === dt.items[i].getAsFile().name) {
                        dt.items.remove(i);
                        continue;
                    }
                }
                document.getElementById('images').files = dt.files;
            });
        });
    </script>

    <script>
        $(".select2").select2();

        const images = document.getElementById("images")
        const output = document.querySelector("output")
        let imagesArray = []

        images.addEventListener("change", () => {
            imagesArray = [];
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
                                    <img src="${URL.createObjectURL(image)}" alt="services image">
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

        $(document).ready(function() {
            $("#frmSubmit").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.services.add') }}",
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
