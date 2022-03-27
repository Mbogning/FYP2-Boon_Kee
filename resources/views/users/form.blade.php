@extends('layouts.sidebar')
@section('title')
    {{ $title }} User
@endsection

@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">User</a>
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
            <h1>{{ $title }} User</h1>
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
                            <input type="text" name="name" id="" class="block w-full text-sm rounded-lg"
                                value="{{ @$user->name }}" placeholder="James Bond">
                        </div>
                        <div class="">
                            <label for="" class="inline-block mb-1">Email: </label>
                            <input type="email" name="email" class="block w-full text-sm rounded-lg"
                                value="{{ @$user->email }}" placeholder="jamesbond@email.com" required>
                        </div>
                        <div class="">
                            <label for="" class="inline-block mb-1">Birth of Date: </label>
                            <input type="date" name="bod" class="block w-full text-sm rounded-lg"
                                value="{{ @$user->bod }}" required>
                        </div>
                        <div class="">
                            <label for="" class="inline-block mb-1">Phone Number: </label>
                            <input type="tel" name="phone" class="block w-full text-sm rounded-lg"
                                value="{{ @$user->phone }}" maxlength="12" placeholder="601232133322" required>
                        </div>
                        <div class="">
                            <label for="" class="inline-block mb-1">Gender: </label>
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
                        <div>
                            <label for="" class="inline-block mb-1">Role: </label>
                            <select name="role_id" id="" class="block w-full text-sm rounded-lg p-3">
                                <option value="">Please Select Role</option>
                                @php
                                    $role_id = null;
                                    $role = @$user->roles;
                                    if ($role) {
                                        $role_id = @$role->first();
                                    }
                                @endphp
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if (@$role_id->id == $role->id) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button class="bg-blue-600 text-white py-2 px-3 rounded-md mr-2">Save</button>
                        <a href="{{ route('user_listing') }}"
                            class="bg-gray-600 text-gray-100 py-2 px-3 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
