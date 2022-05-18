@extends('layouts.app')

@section('head')
    @yield('subhead')
@endsection

@section('sidebar')
    {{-- @include('../layout/components/mobile-menu') --}}
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Midone Tailwind HTML Admin Template" class="w-6"
                    src="{{ asset('images/boonkee-removebg-preview.png') }}">>
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-theme-24 py-5 hidden">
            <li>
                <a href="{{ route('dashboard') }}" class="menu">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> Dashboard </div>
                </a>
            </li>

        </ul>
    </div>
    {{--  --}}
    <div class="flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="{{ route('dashboard') }}" class="intro-x pl-5 pt-4">
                <img alt="Midone Tailwind HTML Admin Template" class="w-20 mx-auto"
                    src="{{ asset('images/boonkee-removebg-preview.png') }}">
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="side-menu__title"> Dashboard </div>
                    </a>
                </li>

                @canany(['user_listing', 'user_form'])
                    <li>
                        <a href="javascript:void(0)" class="side-menu menu-title">
                            <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                            <div class="side-menu__title"> Users <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('user_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Listing </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user_add') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Add User </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <li>
                    <a href="{{ route('view_working_schedule') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                        <div class="side-menu__title"> Work Schedule </div>
                    </a>
                </li>

                @canany(['roles', 'permissions'])
                    <li>
                        <a href="javascript:void(0)" class="side-menu menu-title">
                            <div class="side-menu__icon"> <i data-feather="lock"></i> </div>
                            <div class="side-menu__title"> Roles Permission <i data-feather="chevron-down"
                                    class="side-menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('user_roles_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Roles </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user_permission_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Permissions </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @canany(['menus_listing', 'menus_form', 'menus_type'])
                    <li>
                        <a href="javascript:void(0)" class="side-menu menu-title">
                            <div class="side-menu__icon"> <i data-feather="coffee"></i> </div>
                            <div class="side-menu__title"> Menus <i data-feather="chevron-down" class="side-menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('menu_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Listing </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('menu_add') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> New Menu </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('menu_type_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Menu Type </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany(['reservation_listing', 'reservation_manage', 'reservation_add'])
                    <li>
                        <a href="javascript:void(0)" class="side-menu menu-title">
                            <div class="side-menu__icon"> <i data-feather="briefcase"></i> </div>
                            <div class="side-menu__title"> Reservation <i data-feather="chevron-down"
                                    class="side-menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('reservation_listing') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Listing </div>
                                </a>
                            </li>
                            @can('reservation_add')
                                <li>
                                    <a href="{{ route('reservation_add') }}" class="side-menu">
                                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                        <div class="side-menu__title"> New Reservation </div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['setting_listing', 'setting_manage'])
                    <li>
                        <a href="{{ route('setting_listing') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="box"></i> </div>
                            <div class="side-menu__title"> Setting </div>
                        </a>
                    </li>
                @endcanany

                <li>
                    <a href="index.html" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="box"></i> </div>
                        <div class="side-menu__title"> More </div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @include('layouts.top-bar')
            @if (Session::has('success'))
                <div class="px-5 pt-3">
                    <div class=" bg-green-200 text-green-800 border-green-900 py-3 px-5 rounded-lg">
                        <span class="font-bold">
                            {{ session::get('success') }}
                        </span>
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="px-5 pt-3">
                    <div class=" bg-red-300 text-red-800 border-red-900 py-3 px-5 rounded-lg">
                        <span class="font-bold">
                            {{ session::get('error') }}
                        </span>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
        <!-- END: Content -->
    </div>
@endsection
