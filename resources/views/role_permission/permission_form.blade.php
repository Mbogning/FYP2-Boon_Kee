@extends('layouts.sidebar')
@section('title')
    {{ $title }} Permissions
@endsection
@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Permissions</a>
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
            <h1>{{ $title }} Permission</h1>
        </div>
    </div>
    <div class="p-5">
        <div class="bg-white p-5 rounded-md shadow-sm grid">
            <div class="grid">
                <form action="{{ $submit }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="">
                            <label for="" class="inline-block mb-1">Name: </label>
                            <input type="text" name="name" id="" class="block w-full text-sm rounded-lg border-gray-400"
                                value="{{ @$permission->name }}" placeholder="" required>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button class="bg-blue-600 text-white py-2 px-3 rounded-md mr-2">Save</button>
                        <a href="{{ route('user_permission_listing') }}"
                            class="bg-gray-600 text-gray-100 py-2 px-3 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
