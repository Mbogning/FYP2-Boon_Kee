@extends('layouts.sidebar')
@section('title')
    Reservation Payment
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
            <h1 class="font-bold">Reservation Payment</h1>
        </div>
    </div>
    <div x-data="{ open: false }">
        <div class="p-5">
            <div class="grid p-10 text-xl bg-white rounded-lg shadow-lg">
                <div class="grid grid-cols-2 gap-5">
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

                    </div>
                    <div class="grid gap-5">
                        <div class="mb-3">
                            <label for="" class="inline mb-3">Reservation Date: </label>
                            <span>{{ $reservation->reservation_date }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline mb-3">Reservation Time: </label>
                            <span>{{ date('g:i a', strtotime($reservation->reservation_time)) }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline mb-3">Price: </label>
                            <span class="font-bold">RM {{ $reservation->reservation_total_amount }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5 mt-5">
                    <div class="mb-3">
                        <label for="" class="inline mb-3">
                            Remarks:
                        </label>
                        <textarea name="" readonly
                            class="block rounded-md w-full p-3 border-gray-400">{{ $reservation->reservation_remarks }}</textarea>
                    </div>
                    <div class="mb-3 relative">
                        <div class=" absolute bottom-0 right-0">
                            <button class="px-3 py-2 bg-blue-600 text-white font-bold rounded-lg" aria-expanded="false"
                                aria-haspopup="true" @click="open = !open" type="submit">Orders</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="user-menu-buttoe" role="dialog" aria-modal="true"
            x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="open = !open"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="font-bold mb-10 text-2xl">Orders</div>
                        <table>
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3"></th>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservation->order as $order)
                                    <tr class="mb-3">
                                        @if ($menu_img[$order->menu_id])
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                <img src="{{ $menu_img[$order->menu_id] }}" alt="" class="">
                                            </td>
                                        @else
                                            <td class="text-center">No Image</td>
                                        @endif
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $order->menu->name }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $order->order_quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
