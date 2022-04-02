@extends('welcome')
@section('title', $menu->name)
@section('head')

@endsection
@section('content')
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen">
        {{-- Hero --}}
        <div class="">
            <div class="mt-20">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg"
                    alt="" class="shadow-lg">
            </div>
        </div>
        {{-- Description --}}
        <div class="pt-5">
            <div>
                <div class="mb-5">
                    <h1 class="text-2xl font-bold underline">{{ $menu->name }}</h1>
                </div>
                <div>
                    {!! $menu->description !!}
                </div>
            </div>
        </div>
        {{-- More foods --}}
        <div class="py-5 max-w-xl">
            <div class="mb-5">
                <h1 class="text-xl font-bold">
                    More Food
                </h1>
            </div>
            <div class="flex overflow-x-auto snap-x">
                @foreach ($more_menu as $more)
                    <div class="mr-3 flex-none p-5 w-1/2 snap-center">
                        <a href="">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg" class="rounded-xl brightness-75" />
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
