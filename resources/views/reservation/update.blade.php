@extends('layouts.sidebar')
@section('title')
    Reservation Info
@endsection

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.css" rel="stylesheet">
@endsection

@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Reservation</a>
    </div>
    <!-- END: Breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="p-5">
            @foreach ($errors->all() as $err)
                <div class="bg-red-300 text-red-700 py-3 px-5 rounded-lg">
                    {{ $err }}
                </div>
            @endforeach
        </div>
    @endif
    <div class="px-5">
        <div class="mt-3">
            <h1 class="font-bold">Reservation Info</h1>
        </div>
    </div>
    <div class="p-5">
        <div class="grid">
            <form action="{{ $submit }}" method="post">
                @csrf
                <div class="grid grid-cols-2 gap-5 p-10 text-xl bg-white rounded-lg shadow-lg">
                    <div class="grid gap-5">
                        <div class="mb-3">
                            <label for="" class="inline mb-3">
                                Reservation ID:
                            </label>
                            <span class="">{{ $reservation->id }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline mb-3">
                                Customer Name:
                            </label>
                            <span class="">{{ $reservation->customer->name }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline mb-3">
                                Number of Guest:
                            </label>
                            <span class="">{{ $reservation->reservation_total_guest }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline mb-3">
                                Remarks:
                            </label>
                            <textarea name="" id="" cols="30" rows="10" readonly
                                class="block rounded-md p-3">{{ $reservation->reservation_remarks }}</textarea>
                        </div>

                    </div>
                    <div class="grid gap-5">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="" class="inline mb-3">Reservation Date: </label>
                                <span>{{ $reservation->reservation_date }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="" class="inline mb-3">Reservation Time: </label>
                                <span>{{ date('g:i a', strtotime($reservation->reservation_time)) }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="" class="inline mb-3">Status: </label>
                                <select name="reservation_status"
                                    class="block w-full text-sm rounded-lg border-gray-400 p-3">
                                    @foreach ($reservation_status as $key => $status)
                                        <option value="{{ $key }}"
                                            @if (@$reservation->reservation_status == $key) selected @endif>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 relative">
                            <div class=" absolute bottom-0 right-0">
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg" type="submit">Update</button>
                                <a href="{{ route('reservation_listing') }}"
                                    class="px-3 py-2 bg-gray-600 text-white rounded-lg">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
