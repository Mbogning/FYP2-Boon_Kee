@extends('welcome')
@section('title', 'Reservation History Detail')
@section('content')
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen dark:bg-zinc-800">
        <div class="mt-24 sm:mt-28 mb-10">
            <div class="px-3 py-5 rounded-lg shadow-lg sm:p-5 md:p-10 bg-white dark:bg-zinc-700">
                <div class="grid">
                    <div class="text-center sm:text-left text-xl font-bold dark:text-white my-5">Reservation Details</div>
                    <div class="border-b my-5">
                        <div class="mb-5">
                            <div class="text-xl sm:text-2xl font-bold dark:text-white">Order #{{ $reservation->id }}</div>
                            <div>
                                @php
                                    $status = '';
                                    switch ($reservation->reservation_status) {
                                        case 'Pending':
                                            $status = '<span class="text-xs text-white bg-amber-400 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
                                            break;
                                        case 'Paid':
                                            $status = '<span class="text-xs text-white bg-teal-400 py-1 px-2 rounded-md">' . $reservation->reservation_status . '</span>';
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
                                {!! $status !!}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div class="grid gap-2">
                                <h1 class="font-bold text-sm sm:text-xl dark:text-white">Date & Time</h1>
                                <p class="text-xs sm:text-sm dark:text-white">
                                    {{ date('d F Y', strtotime($reservation->reservation_date)) }}
                                    {{ date('g:i A', strtotime($reservation->reservation_time)) }}
                                </p>
                            </div>
                            <div class="grid gap-2">
                                <h1 class="font-bold text-sm sm:text-xl dark:text-white">Amount Paid</h1>
                                <p class="text-xs sm:text-sm dark:text-white">
                                    RM {{ number_format($reservation->reservation_total_amount, 2) }}
                                </p>
                            </div>
                            <div class="grid gap-2">
                                <h1 class="font-bold text-sm sm:text-xl dark:text-white">Total Guest</h1>
                                <p class="text-xs sm:text-sm dark:text-white">{{ $reservation->reservation_total_guest }}
                                </p>
                            </div>
                            <div>
                                <h1 class="font-bold text-sm sm:text-xl dark:text-white">Remarks</h1>
                                <p class="text-xs sm:text-sm dark:text-white">{{ $reservation->reservation_remarks ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-b my-5">
                        <div class="text-xl sm:text-2xl font-bold mb-3 dark:text-white">Orders</div>
                        @php
                            $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
                        @endphp
                        <div class="grid mb-5">
                            @foreach ($reservation->order as $order)
                                <div class="flex mb-3 p-5">
                                    <div class="basis-1/2 sm:basis-1/3 mr-3">
                                        <img src="{{ $get_menu_imgs[$order->menu->slug] ?? $url }}" alt=""
                                            class="rounded-lg shadow-md">
                                    </div>
                                    <div class="basis-1/2 sm:basis-2/3">
                                        <h1 class="font-black sm:text-2xl dark:text-white">{{ $order->menu->name }}</h1>
                                        <h1 class="font-black sm:text-2xl dark:text-white">RM
                                            {{ number_format($order->order_price, 2) }}
                                        </h1>
                                        <p class="font-black sm:text-xl dark:text-white">x {{ $order->order_quantity }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="p-2 grid dark:text-white">
                            <label for="" class="text-xl font-bold">Payment Slip</label>
                            <a href="{{ $get_reservation_media }}" target="_blank" class="underline">
                                View Payment
                            </a>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="text-xl sm:text-2xl font-black dark:text-white">Total</div>
                        <div class="text-xl sm:text-2xl font-black dark:text-white">RM
                            {{ number_format($reservation->reservation_total_amount, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
