@extends('welcome')
@section('title', 'Menus')
@section('head')
    <style>

    </style>
@endsection
@section('content')
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen">
        <div class="">
            @php
                $url = "https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg";
            @endphp
            @foreach ($menu_type as $type)
                <div class="mt-20 px-0 py-5 sm:p-5 md:p-10">
                    <div class="mb-5">
                        <h1 class="text-2xl font-bold">{{ $type->name }}</h1>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4 gap-5 sm:gap-10">
                        @foreach ($menus as $menu)
                            @if ($type->id == $menu->type)
                                <div
                                    class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 hover:scale-105 ease-in-out transition-all duration-200 hover:shadow-lg">
                                    <a href="{{ route('view_menu_info', $menu->slug) }}">
                                        <img class="rounded-t-lg"
                                            src="{{ @$imgs[$menu->slug] ?? $url }}"
                                            alt="" />
                                    </a>
                                    <div class=" p-5">
                                        <a href="{{ route('view_menu_info', $menu->slug) }}">
                                            <h5
                                                class="mb-2 text-md sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                {{ $menu->name }}</h5>
                                        </a>
                                        <div
                                            class="mb-3 text-xs sm:text-sm font-normal text-gray-700 dark:text-gray-400 line-clamp-3 overflow-hidden">
                                            {!! $menu->description ?? 'No Description' !!}
                                        </div>
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
