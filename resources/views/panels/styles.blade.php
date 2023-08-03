@php
    $css_path = app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
@endphp
@if (app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors-rtl.min.css')) }}" />
@else
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />
@endif

@yield('vendor-style')

<link rel="stylesheet" href="{{ asset(mix($css_path . '/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix($css_path . '/base/themes/dark-layout.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix($css_path . '/base/themes/bordered-layout.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix($css_path . '/base/themes/semi-dark-layout.css')) }}" />

@php $configData = Helper::applClasses(); @endphp

@if ($configData['mainLayoutType'] === 'horizontal')
    <link rel="stylesheet" href="{{ asset(mix($css_path . '/base/core/menu/menu-types/horizontal-menu.css')) }}" />
@else
    <link rel="stylesheet" href="{{ asset(mix($css_path . '/base/core/menu/menu-types/vertical-menu.css')) }}" />
@endif

@yield('page-style')

<link rel="stylesheet" href="{{ asset(mix($css_path . '/overrides.css')) }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@if (app()->getLocale() === 'ar')
    <link rel="stylesheet" href="{{ asset(mix($css_path . '/custom-rtl.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix($css_path . '/style-rtl.css')) }}" />
@else
    <link rel="stylesheet" href="{{ asset(mix($css_path . '/style.css')) }}" />
@endif

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" type="text/css">
<link href="https://fontlibrary.org//face/droid-arabic-kufi" rel="stylesheet" media="screen" type="text/css" />
