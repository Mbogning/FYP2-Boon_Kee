@extends('layouts.sidebar')
@section('title')
    Permissions Listing
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
    <div class="p-5">
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div>
                <h1 class="font-bold flex justify-start items-center">
                    Permissions listing
                    <a href="{{ route('user_permission_add') }}"
                        class="border border-green-500 text-green-500 hover:bg-green-500 hover:text-white py-1.5 px-3 rounded-md ml-2 text-xs items-center flex justify-center">
                        <i class="bx bx-plus bx-xs mr-1"></i> ADD
                    </a>
                </h1>
            </div>
        </div>
    </div>
    <div>
        <div class="p-5">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Permission</th>
                            <th class="px-6 py-3">Created On</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($permissions as $permission)
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $i + $permissions->firstItem()}}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                <b>{{ $permission->name }}</b>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ date_format($permission->created_at, 'Y-m-d H:i A') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                <a href="{{ route('user_permission_edit', $permission->id) }}"
                                    class="border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                {!! $permissions->links() !!}
            </div>
        </div>
    </div>
@endsection