@extends('welcome')
@section('title', 'Menus')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <style>

    </style>
@endsection
@section('content')
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen dark:bg-zinc-800">
        <div class="">
            @php
                $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
            @endphp
            @foreach ($menu_type as $type)
                <div class="mt-20 px-0 py-5 sm:p-5 md:p-10">
                    <div class="mb-5">
                        <h1 class="text-2xl font-bold dark:text-gray-400">{{ $type->name }}</h1>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4 gap-5 sm:gap-10">
                        @foreach ($menus as $menu)
                            @if ($type->id == $menu->type)
                                <div class="relative max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-zinc-700 dark:border-gray-700 hover:scale-105 ease-in-out transition-all duration-200 hover:shadow-lg"
                                    data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-id="{{ $menu->id }}">
                                    <a href="{{ route('view_menu_info', $menu->slug) }}">
                                        <img class="rounded-t-lg" src="{{ @$imgs[$menu->slug] ?? $url }}" alt="" />
                                    </a>
                                    <div class="relative p-5 mb-10">
                                        <a href="{{ route('view_menu_info', $menu->slug) }}">
                                            <h5
                                                class="mb-2 text-md sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                {{ $menu->name }}</h5>
                                        </a>
                                        <div
                                            class="mb-3 text-xs sm:text-sm font-normal text-gray-700 dark:text-gray-400 line-clamp-1 overflow-hidden pb-6">
                                            {!! $menu->description ?? 'No Description' !!}
                                        </div>
                                    </div>
                                    <div class="p-5 sm:flex justify-between absolute bottom-0 w-full">
                                        <a href="{{ route('view_menu_info', $menu->slug) }}"
                                            class="inline-flex items-center py-2 px-3 text-xs sm:text-sm font-medium text-center text-white bg-amber-300 rounded-lg hover:bg-amber-400 focus:ring-4 focus:outline-none focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
                                            View more
                                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                        <button
                                            class="hidden sm:flex items-center py-2 px-3 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs sm:text-sm add_to_cart_btn"
                                            data-id="{{ $menu->id }}" @if (@$cart[$menu->id]) disabled @endif>
                                            <i class='bx bx-check-circle {{ @$cart[$menu->id] ? 'block' : 'hidden' }}'>
                                            </i>
                                            <i class='bx bx-cart-add {{ @$cart[$menu->id] ? 'hidden' : 'block' }} '>
                                            </i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/aos.js') }}"></script>
    <script>
        AOS.init();
        $(document).ready(function() {

        })

        $(document).on('click', '.add_to_cart_btn', function() {
            let menu_id = $(this).data('id');
            add_to_cart(menu_id);
        })

        function add_to_cart(menu_id) {
            @if (auth()->check())
                $.ajax({
                    url: "{{ route('ajax_add_to_cart') }}",
                    method: "Post",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'menu_id': menu_id
                    },
                    success: (s) => {
                        $('button[data-id="' + menu_id + '"]').prop('disabled', true)
                        $('button[data-id="' + menu_id + '"]').find('.bx-cart-add').hide()
                        $('button[data-id="' + menu_id + '"]').find('.bx-check-circle').show()
                    },
                    error: (e) => {
                        console.log(e);
                    }
                })
            @else
                window.location.href = "{{ route('login') }}"
            @endif
        }
    </script>
@endsection
