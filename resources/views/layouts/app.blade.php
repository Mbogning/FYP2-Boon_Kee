<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/boonkee-removebg-preview.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/midone.css') }}">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/midone.js') }}" defer></script> --}}

    @yield('head')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        @if (Session::has('success'))
            <div class="p-5">
                <div class=" bg-green-200 text-green-800 border-green-900 py-3 px-5 rounded-lg">
                    <span class="font-bold">
                        {{ session::get('success') }}
                    </span>
                </div>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="p-5">
                <div class=" bg-red-300 text-red-800 border-red-900 py-3 px-5 rounded-lg">
                    <span class="font-bold">
                        {{ session::get('error') }}
                    </span>
                </div>
            </div>
        @endif
        @yield('content')
        {{ $slot ?? '' }}
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('script')
</body>

</html>
