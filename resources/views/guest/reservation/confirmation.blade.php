@extends('welcome')
@section('title', 'Confirmation - Reservation')
@section('head')

@endsection
@section('content')
    <div class="min-h-screen">
        <div class="p-5 sm:p-10 min-h-screen">
            <div class="sm:p-20 grid gap-10">
                <form action="" method="post">
                    @csrf
                    <div class="grid gap-10">
                        <div class="flex justify-between">
                            <h1 class="text-3xl text-yellow-500 font-bold">Reservation Info</h1>
                            <button type="submit" class="bg-yellow-400 py-3 px-5 rounded-lg shadow-md">Submit</button>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-10">
                            <div
                                class="grid grid-cols-4 gap-10 p-5 bg-white dark:bg-zinc-700 dark:text-white rounded-xl shadow-lg">
                                <div class="col-span-1">
                                    <div class="p-10 rounded-lg bg-zinc-200"></div>
                                </div>
                                <div class="col-span-3 grid items-center">
                                    <div class="block">{{ $customer->name }}</div>
                                    <div class="block">{{ $customer->phone }}</div>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="sm:absolute bottom-0 right-0">
                                    <input type="file" name="reservation_payment"
                                        class="file:bg-yellow-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold p-3 dark:text-white"
                                        id="">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="grid bg-white dark:bg-zinc-700 rounded-lg shadow-md p-3 sm:p-10 dark:text-white">
                    {{-- reservation info --}}
                    <div class="grid sm:grid-cols-2">
                        <div>Date: {{ $reservation->reservation_date }}</div>
                        <div>Time: {{ date('g:i A', strtotime($reservation->reservation_time)) }}</div>
                        <div>Total Guest: {{ $reservation->reservation_total_guest }}</div>
                        <div>Total Amount: RM {{ $reservation->reservation_total_amount }}</div>
                    </div>
                    {{-- orders --}}
                    <div class="mt-3 border-t">
                        <div class="font-bold sm:text-xl mt-3 dark:text-white">Orders </div>
                        <div class="mt-3 grid sm:grid-cols-2 gap-5">
                            @foreach ($reservation->order as $order)
                                @php
                                    $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
                                @endphp
                                <div class="">
                                    <div class="shadow-md">
                                        <img src="{{ $get_menu_imgs[$order->menu->slug] ?? $url }}" alt=""
                                            class="rounded-lg">
                                    </div>
                                    <div class="mt-3 text-center">
                                        <h3 class="text-xl font-bold">{{ $order->menu->name }} x
                                            {{ $order->order_quantity }}</h3>
                                        <p>RM {{ number_format($order->order_price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
