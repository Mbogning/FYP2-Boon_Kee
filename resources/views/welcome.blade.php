<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/boonkee-removebg-preview.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        i.bx {
            font-size: 1.5rem
        }

    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('head')
</head>

<body class="antialiased">
    <div class="fixed w-full backdrop-blur-lg bg-white/60 dark:bg-slate-800/60 z-[51]">
        <nav class="px-5 sm:px-12 py-8 flex items-center whitespace-nowrap">
            <div class="flex mr-20">
                <h1 class="font-black text-2xl">
                    <a href="{{ route('welcome') }}">
                        BOON KEE
                    </a>
                </h1>
            </div>
            <div class="flex justify-between w-full items-center">
                <ul class="flex">
                    <li class="mr-8">
                        <a href="" class="text-sm font-bold">MENU</a>
                    </li>
                    <li class="mr-8">
                        <a href="" class="text-sm font-bold">ABOUT US</a>
                    </li>
                </ul>
                <ul class="flex">
                    @auth
                        <li class="mr-8">
                            <a href="">
                                <i class='bx bxs-cart'></i>
                            </a>
                        </li>
                        <li class="mr-8">
                            <a href="{{ route('profile') }}">
                                <i class='bx bxs-user-circle'></i>
                            </a>
                        </li>
                        <li class="mr-8">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                {{-- <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();this.closest('form').submit(); sessionStorage.clear()">
                                    
                                </a> --}}
                                <button type="submit">
                                    <i class='bx bx-log-out'></i>
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="mr-8">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log
                                in</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="mr-8">
                                <a href="{{ route('register') }}"
                                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                            </li>
                        @endif
                    @endauth
                    <li>
                        <div>
                            <button class="hidden">
                                <i class='bx bxs-sun text-yellow-400'></i>
                            </button>
                            <button>
                                <i class='bx bxs-moon'></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    {{-- @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif --}}

    {{-- Hero --}}
    <div class="min-h-screen bg-slate-100 relative">
        @yield('content')
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
    @yield('script')

    <script>
        @if (Session::has('success'))
            $.toast({
            heading: 'Success',
            text: '{{ session::get('success') }}',
            showHideTransition: 'slide',
            icon: 'success'
            })
        @endif
        @if (Session::has('error'))
            $.toast({
            heading: 'Error',
            text: '{{ session::get('error') }}',
            showHideTransition: 'fade',
            icon: 'error'
            })
        @endif
    </script>
</body>

</html>
