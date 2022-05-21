@extends('welcome')
@section('title', 'Confirmation - Reservation')
@section('head')

@endsection
@section('content')
    <div class="min-h-screen">
        <div class="p-5 sm:p-10 min-h-screen">
            <div class="sm:p-20 grid gap-10">
                <div class="grid gap-10">
                    <div>
                        <h1 class="text-3xl text-yellow-500 font-bold">Reservation Info</h1>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-10">
                        <div class="grid grid-cols-4 gap-10 p-5 bg-white rounded-xl shadow-lg">
                            <div class="col-span-1">
                                <div class="p-10 rounded-lg bg-zinc-200"></div>
                            </div>
                            <div class="col-span-3 grid items-center">
                                <div class="block">{{ $customer->name }}</div>
                                <div class="block">{{ $customer->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid bg-white rounded-lg shadow-md p-3 sm:p-10">
                    <div></div>
                </div>
            </div>
        </div>
    </div>
@endsection
