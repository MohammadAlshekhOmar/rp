@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
        data-nav="brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class="">
                            <img style="width: 50px;"
                                src="{{ asset(mix('images/logo.jpg')) }}" alt="" />  
                        </span>
                        <h2 class="brand-text mb-0">{{ $brand }}</h2>
                    </a>
                </li>
            </ul>
        </div>
    @else
        <nav
            class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
@endif

<div class="navbar-container d-flex content">
    <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><svg
                        xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-menu ficon">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg></a></li>
        </ul>
        <ul class="nav navbar-nav bookmark-icons">
        </ul>
    </div>
    <ul class="nav navbar-nav align-items-center ms-auto">
        <li class="nav-item dropdown dropdown-language">
            <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                aria-haspopup="true">
                <i class="flag-icon flag-icon-us"></i>
                <span class="selected-language">اللغة</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                <a class="dropdown-item" href="{{ route($guard . '.swap', ['locale' => 'ar']) }}" data-language="ar">
                    <i class="flag-icon flag-icon-sa"></i> العربية
                </a>
                <a class="dropdown-item" href="{{ route($guard . '.swap', ['locale' => 'en']) }}" data-language="en">
                    <i class="flag-icon flag-icon-us"></i> English
                </a>
            </div>
        </li>
        {{-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                    data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i></a></li> --}}
        <li class="nav-item dropdown dropdown-notification me-25">
            <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="ficon" data-feather="bell"></i>
                <span class="badge rounded-pill bg-danger badge-up"
                    id="numberNotification">{{ $number_notifications }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                <li class="dropdown-menu-header">
                    <div class="dropdown-header d-flex">
                        <h4 class="notification-title mb-0 me-auto">الإشعارات</h4>
                        <div class="badge rounded-pill badge-light-primary">{{ $number_notifications }} جديدة
                        </div>
                    </div>
                </li>
                <li class="scrollable-container media-list notification-list">
                    @foreach ($notis as $noti)
                        <a class="d-flex notification-item" style="background:#DDD" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1" style="text-align:center;">
                                    <p>User</p>
                                    <div class="avatar">
                                        <img src="{{ asset('images/icons/notification.png') }}" alt="avatar"
                                            width="40" height="40">
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">{{ $noti->title }}
                                    </p>
                                    <small class="notification-text">{{ $noti->text }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown dropdown-user">
            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                data-bs-toggle="dropdown" aria-haspopup="true">
                <div class="user-nav d-sm-flex d-none">
                    <span class="user-name fw-bolder">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="user-status">
                        {{ $model }}
                    </span>
                </div>
                <span class="avatar">
                    <img class="round"
                        src="{{ auth()->user()? auth()->user()->getFirstMediaUrl($model): asset(mix('images/portrait/small/avatar-s-11.jpg')) }}"
                        alt="avatar" height="40" width="40">
                    <span class="avatar-status-online"></span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                <h6 class="dropdown-header">المعلومات الشخصية</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item"
                    href="{{ route($guard . '.' . $route . '.showEdit', ['id' => auth()->user()->id]) }}">
                    <i class="me-50" data-feather="user"></i> الملف الشخصي
                </a>
                <a class="dropdown-item" href="{{ route($guard . '.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="me-50" data-feather="power"></i> تسجيل الخروج
                </a>
                <form method="POST" id="logout-form" action="{{ route($guard . '.logout') }}">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</div>
</nav>
