@extends('layouts.sidebar')
@section('title')
    Dashboard
@endsection
@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Dashboard</a>
    </div>
    <!-- END: Breadcrumb -->
@endsection
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Welcome Back! {{ auth()->user()->name }}
                </div>
                <div class="p-6 bg-white">
                    Role: <b>{{ auth()->user()->roles[0]->name }}</b>
                </div>
            </div>
        </div>
    </div>
@endsection
