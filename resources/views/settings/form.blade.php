@extends('layouts.sidebar')
@section('title')
    {{ $title }} Setting
@endsection
@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Setting</a>
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
        <div class="my-5">
            <h1>{{ $title }} Setting</h1>
        </div>
    </div>
    <div class="p-5 bg-white rounded-md shadow-md">
        <form action="{{ $submit }}" method="post">
            @csrf
            <div class="grid gap-5 ">
                <div class="grid gap-3">
                    <label for="" class="mb-3">Name: <span class="text-red-400">*</span></label>
                    <input type="text" name="setting_name" class="block border-gray-500 rounded-md"
                        value="{{ @$setting->setting_name }}">
                </div>
                <div class="grid gap-3">
                    <label for="" class="mb-3">Value: <span class="text-red-400">*</span></label>
                    <textarea name="setting_value" class="border-gray-500 rounded-md p-3">{{ @$setting->setting_value }}</textarea>
                </div>
                <div>
                    <button class="py-2.5 px-3 bg-blue-600 text-white rounded-md">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
