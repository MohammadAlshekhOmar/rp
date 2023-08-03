@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts.fullLayoutMaster')

@section('title', __('admin.login_page'))

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/pages/authentication.css') }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-cover">
        <div class="auth-inner row m-0">
            <div class="col-lg-4 align-items-center auth-bg px-2 p-lg-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset(mix('images/logo.jpg')) }}" style="width:100px;" alt="logo">
                    <h2 class="brand-text text-primary ms-1">{{ $brand }}</h2>
                </a>

                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                    <div id="alertError" class="alert alert-danger mt-4" role="alert" style="display:none;">
                        <h4 class="alert-heading">{{ __('general.fail') }}</h4>
                        <div class="alert-body">
                            <div class="alert-text font-weight-bold">
                                <div id="listError"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h2 class="card-title fw-bold mb-1">{{ __('admin.welcome') . ' ' . $brand }}</h2>
                    <p class="card-text mb-2">{{ __('admin.please_login') }}</p>
                    <form class="auth-login-form mt-2" id="frmLogin">
                        @csrf
                        <div class="mb-1">
                            <label class="form-label" for="login-email">{{ __('field.email') }}</label>
                            <input class="form-control" id="login-email" type="text" name="email"
                                placeholder="{{ __('general.enter') . ' ' . __('field.email') }}"
                                aria-describedby="login-email" autofocus="" tabindex="1" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="login-password">{{ __('field.password') }}</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge" id="login-password" type="password"
                                    name="password" placeholder="{{ __('general.enter') . ' ' . __('field.password') }}"
                                    aria-describedby="login-password" tabindex="2" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-relief-primary w-100 submitFrom">
                            <span>{{ __('admin.login') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    @if ($configData['theme'] === 'dark')
                        <img class="img-fluid" src="{{ asset('images/pages/login-v2-dark.svg') }}" alt="Login V2" />
                    @else
                        <img class="img-fluid" src="{{ asset('images/pages/login-v2.svg') }}" alt="Login V2" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('js/scripts/pages/auth-login.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#frmLogin").on("submit", function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('admin.login') }}",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#listError').empty();
                        $("#alertError").hide();
                        $(".submitFrom span").html('{{ __('admin.logining') }}');
                        $('.submitFrom').prop('disabled', true);
                    },
                    success: function(response, textStatus, xhr) {
                        if (xhr.status == 200) {
                            window.location.href = "{{ route('admin.cp') }}";
                        } else {
                            $("#alertError").show();
                            $('#listError').html(data.message);
                        }

                        $("html, body").animate({
                            scrollTop: 0
                        }, {
                            duration: 1500,
                        });
                        $(".submitFrom span").html('{{ __('admin.login') }}');
                        $('.submitFrom').prop('disabled', false);
                    },
                    error: function(response) {
                        $("#alertError").show();
                        var errors = response.responseJSON.errors;
                        if (errors) {
                            for (var error in errors) {
                                var ul = document.getElementById("listError");
                                var li = document.createElement("li");
                                li.appendChild(document.createTextNode(errors[error]));
                                ul.appendChild(li);
                            }
                        } else {
                            $('#listError').html(response.responseJSON.message);
                        }

                        $("html, body").animate({
                            scrollTop: 0
                        }, {
                            duration: 1500,
                        });
                        $(".submitFrom span").html('{{ __('admin.login') }}');
                        $('.submitFrom').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
