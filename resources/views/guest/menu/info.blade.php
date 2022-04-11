@extends('welcome')
@section('title', $menu->name)
@section('head')

@endsection
@section('content')
    @php
    $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
    @endphp
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen">
        {{-- Hero --}}
        <div class="h-full">
            <div class="mt-20">
                <img src="{{ $menu_img ?? $url }}" alt="" class="w-full bg-fixed rounded-b-xl">
            </div>
        </div>
        {{-- Description --}}
        <div class="pt-5 sm:p-10 sm:relative sm:bg-white sm:rounded-xl sm:-top-20 sm:w-3/4 sm:mx-auto sm:shadow-lg">
            <div>
                <div class="mb-5">
                    <h1 class="text-5xl font-bold">{{ $menu->name }}</h1>
                </div>
                <div class="mb-5">
                    <p class="text-md">
                        Price : <b>RM {{ number_format($menu->price, 2) }}</b>
                    </p>
                </div>
                <div class="mb-5 text-justify">
                    {!! $menu->description !!}
                </div>
            </div>
        </div>
        {{-- More foods --}}
        <div class="py-5 max-w-[20rem] sm:max-w-xl">
            <div class="mb-5">
                <h1 class="text-xl font-bold">
                    More Food
                </h1>
            </div>
            <div class="flex overflow-x-auto snap-x">
                @foreach ($more_menu as $more)
                    <div class="mr-3 flex-none p-5 w-1/2 snap-center">
                        <a href="{{ route('view_menu_info', $more->slug) }}">
                            <img src="{{ @$imgs[$more->slug] ?? $url }}" class="rounded-xl brightness-75" />
                        </a>
                        <p
                            class="text-xs -translate-y-6 text-white font-semibold sm:-translate-y-8 sm:text-base translate-x-3">
                            {{ $more->name }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
