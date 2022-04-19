@extends('layouts.sidebar')
@section('title')
    {{ $title }} Reservation
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
            <h1 class="font-bold">{{ $title }} Reservation</h1>
        </div>
    </div>
    <div class="p-5">
        <div class="grid">
            <form action="{{ $submit }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-5 bg-white shadow-lg rounded-lg p-5">
                    <div class="grid gap-3">
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Customer Name: <span
                                    class="text-red-600">*</span></label>
                            <input type="text" name="customer_name" class="block w-full text-sm rounded-lg border-gray-400"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Number of People: <span
                                    class="text-red-600">*</span></label>
                            <input type="number" name="number_of_people"
                                class="block w-full text-sm rounded-lg border-gray-400" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Remarks: </label>
                            <textarea name="remarks" class="block w-full text-sm rounded-lg border-gray-400 p-3 h-20"></textarea>
                        </div>
                    </div>
                    <div class="grid gap-3">
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Date: <span
                                    class="text-red-600">*</span></label>
                            <input type="date" name="reservation_date" class="block w-full text-sm rounded-lg border-gray-400"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Time: <span
                                    class="text-red-600">*</span></label>
                            <input type="time" name="reservation_time" class="block w-full text-sm rounded-lg border-gray-400"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Status: <span
                                    class="text-red-600">*</span></label>
                            <select name="" class="block w-full text-sm rounded-lg border-gray-400 p-3">
                                <option value="">Please Select Status</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="px-3 py-2.5 bg-amber-400 text-white rounded-lg" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
