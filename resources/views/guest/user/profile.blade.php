@extends('welcome')
@section('title', 'Profile')
@section('head')
    <style>
        .tab {
            display: none;
        }

        .tab.active {
            display: block
        }

    </style>
@endsection
@section('content')
    <div class="grid grid-cols-4 min-h-screen">
        <div class="col-span-1 bg-slate-500">
            <div class="pt-[5.75rem]">
                <div class="py-5 px-10 text-center grid">
                    <a class="bg-white px-5 py-2.5 mb-5 rounded-md shadow-md text-yellow-600" href="javascript:void(0);" data-toggle="tab"
                        data-target="#profile">
                        Profile Details
                    </a>
                    <a class="bg-white px-5 py-2.5 mb-5 rounded-md shadow-md" href="javascript:void(0);" data-toggle="tab"
                        data-target="#order-history">
                        Reservation History
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-3 bg-yellow-300">
            <div class="pt-[5.75rem]">
                <div class="p-5">
                    <div class="bg-white h-full w-ful p-10 rounded-xl shadow-lg tab active" id="profile">
                        <form action="{{ route('profile') }}" method="post">
                            @csrf
                            <div class="mb-5">
                                <h1 class="underline font-bold text-2xl">
                                    My Profile
                                </h1>
                            </div>
                            <div class="grid grid-cols-2 gap-10">
                                <div>
                                    <label for="" class="inline-block mb-2">Fullname: </label>
                                    <input type="text" name="name" class="block rounded-md w-full"
                                        value="{{ $user->name }}">
                                </div>
                                <div>
                                    <label for="" class="inline-block mb-2">Email: </label>
                                    <input type="email" class="block border-0 rounded-md w-full"
                                        value="{{ $user->email }}" disabled>
                                </div>
                                <div>
                                    <label for="" class="inline-block mb-2">Phone Number: </label>
                                    <input type="tel" name="phone" class="block rounded-md w-full"
                                        value="{{ $user->phone }}">
                                </div>
                                <div>
                                    <label for="" class="inline-block mb-2">Birth of Date: </label>
                                    <input type="date" name="bod" class="block rounded-md w-full"
                                        value="{{ $user->bod }}">
                                </div>
                                <div>
                                    <label for="" class="inline-block mb-2">Gender: </label>
                                    <div class="flex">
                                        @foreach ($gender as $key => $gen)
                                            <div class="mr-2">
                                                <input type="radio" name="gender" id="{{ $key }}"
                                                    value="{{ $key }}"
                                                    class="mr-2 w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
                                                    @if (@$user->gender == $key) checked @endif>
                                                <label for="{{ $key }}">{{ $gen }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="flex mt-10">
                                <button type="submit" class="mr-3 px-5 py-2.5 bg-yellow-200 rounded-lg">
                                    Save
                                </button>
                                <a href="{{ route('welcome') }}" class="px-5 py-2.5 bg-slate-700 text-white rounded-lg">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                    <div id="order-history" class="bg-white h-full w-ful p-10 rounded-xl shadow-lg tab">
                        <div class="mb-5">
                            <h1 class="underline font-bold text-2xl">
                                Reservation History
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('a[data-toggle="tab"]').click(function() {
            $('a[data-toggle="tab"]').map(function() {
                $(this).removeClass('text-yellow-600');
            })
            $('.tab').map(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('text-yellow-600');
            let id = $(this).data('target');
            $(id).addClass('active').fadeIn();
        });
    </script>
@endsection
