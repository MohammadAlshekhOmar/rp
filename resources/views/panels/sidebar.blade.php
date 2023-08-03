@php
    $configData = Helper::applClasses();
@endphp

<div class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
    data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row" style="display: flex;justify-content: space-between;">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="">
                        <img style="width: 32px;"
                                src="{{ asset(mix('images/logo.jpg')) }}" alt="" />
                    </span>
                    <h2 class="brand-text">{{ $brand }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if (isset($menuData[0]))
                @foreach ($menuData[0]->menu as $menu)
                    @if (isset($menu->navheader))
                        @if (!isset($menu->permissions))
                            <li class="navigation-header">
                                <span>{{ __('locale.' . $menu->navheader) }}</span>
                                <i data-feather="more-horizontal"></i>
                            </li>
                        @else
                            @canany($menu->permissions)
                                <li class="navigation-header">
                                    <span>{{ __('locale.' . $menu->navheader) }}</span>
                                    <i data-feather="more-horizontal"></i>
                                </li>
                            @endcanany
                        @endif
                    @else
                        @php
                            $custom_classes = '';
                            if (isset($menu->classlist)) {
                                $custom_classes = $menu->classlist;
                            }
                        @endphp
                        @if (!isset($menu->permissions))
                            <li
                                class="nav-item {{ $custom_classes }} {{ in_array(request()->segment(2), $menu->slug) ? 'active' : '' }}">
                                <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}"
                                    class="d-flex align-items-center"
                                    target="{{ isset($menu->newTab) ? '_blank' : '_self' }}">
                                    <i data-feather="{{ $menu->icon }}"></i>
                                    <span class="menu-title text-truncate">{{ __('locale.' . $menu->name) }}</span>
                                    @if (isset($menu->badge))
                                        <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                        <span
                                            class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                    @endif
                                </a>
                                @if (isset($menu->submenu))
                                    @include('panels.submenu', ['menu' => $menu->submenu])
                                @endif
                            </li>
                        @else
                            @canany($menu->permissions)
                                <li
                                    class="nav-item {{ $custom_classes }} {{ in_array(request()->segment(2), $menu->slug) ? 'active' : '' }}">
                                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}"
                                        class="d-flex align-items-center"
                                        target="{{ isset($menu->newTab) ? '_blank' : '_self' }}">
                                        <i data-feather="{{ $menu->icon }}"></i>
                                        <span class="menu-title text-truncate">{{ __('locale.' . $menu->name) }}</span>
                                        @if (isset($menu->badge))
                                            <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                            <span
                                                class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                        @endif
                                    </a>
                                    @if (isset($menu->submenu))
                                        @include('panels.submenu', ['menu' => $menu->submenu])
                                    @endif
                                </li>
                            @endcanany
                        @endif
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>
