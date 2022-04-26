@extends('layouts.sidebar')
@section('title')
    Resevation Listing
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
    <div class="p-5">
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div>
                <h1 class="font-bold flex justify-start items-center">
                    Reservation listing
                    @can('reservation_add')
                        <a href="{{ route('reservation_add') }}"
                            class="border border-green-500 text-green-500 hover:bg-green-500 hover:text-white py-1.5 px-3 rounded-md ml-2 text-xs items-center flex justify-center">
                            <i class="bx bx-plus bx-xs mr-1"></i> ADD
                        </a>
                    @endcan
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
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Items</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($reservations->isNotEmpty())
                            {{-- @dd($reservations) --}}
                            @foreach ($reservations as $key => $reservation)
                                @php
                                    $status = '';
                                    switch ($reservation->reservation_status) {
                                        case 'Pending':
                                            $status = '<span class="text-xs text-white bg-amber-400 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
                                            break;
                                        case 'Arrived':
                                            $status = '<span class="text-xs text-white bg-blue-500 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
                                            break;
                                        case 'Completed':
                                            $status = '<span class="text-xs text-white bg-green-600 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
                                            break;
                                        case 'Cancelled':
                                            $status = '<span class="text-xs text-white bg-red-400 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $reservations->firstItem() + $key }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <b>{{ $reservation->customer->name }}</b><br>
                                        Guest: <p class="inline">{{ $reservation->reservation_total_guest }}</p>
                                        <br>
                                        <b>Special Remarks: </b><br>
                                        <span>
                                            {{ $reservation->reservation_remarks }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($reservation->order)
                                            @foreach ($reservation->order as $order)
                                                {{ $order->menu->name }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ date_format($reservation->created_at, 'Y-m-d H:i A') }}<br>
                                        {!! $status !!}<br>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @role('Admin')
                                            <a href="{{ route('reservation_edit', $reservation->id) }}"
                                                class="border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                                Edit
                                            </a>
                                        @else
                                            <a href="{{ route('reservation_update', $reservation->id) }}"
                                                class="border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                                Edit
                                            </a>
                                        @endrole
                                        <button
                                            class="text-red-500 hover:text-white border border-red-500 hover:bg-red-400 font-medium rounded-md text-xs px-3 py-1.5 text-center mr-2 mb-2">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center p-5" colspan="5">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
