@extends('layouts.sidebar')
@section('title')
    {{ $title }} Menu Type
@endsection
@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Menu Type</a>
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
        <div>
            <h1>{{ $title }} Menu Type</h1>
        </div>
    </div>
    <div class="p-5">
        <div class="grid ">
            <form action="{{ $submit }}" method="POST">
                @csrf
                <div class="grid grid-cols-4 gap-5">
                    <div class="grid gap-4 col-span-3 bg-white rounded-lg shadow-lg p-5">
                        <div class="">
                            <label for="" class="inline-block mb-3">Name: </label>
                            <input type="text" name="name" id="" class="block w-full text-sm rounded-lg border-gray-400"
                                value="{{ @$type->name }}" required>
                        </div>
                        <div>
                            <label for="" class="inline-block mb-3">Status: </label>
                            <select name="status" id="" class="block w-full text-sm rounded-lg p-2 border-gray-400">
                                @foreach ($status as $key => $stat)
                                    <option value="{{ $key }}" @if (@$type->status == $key) selected @endif>
                                        {{ $stat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button class="bg-blue-600 text-white py-2.5 px-3 rounded-md mr-2">
                                Save
                            </button>
                            <a href="{{ route('menu_type_listing') }}" class="bg-gray-600 text-white py-2 px-3 rounded-md mr-2">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
