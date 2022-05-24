@extends('layouts.sidebar')
@section('title')
    {{ $title }} Reservation
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
            <h1 class="font-bold">{{ $title }} Reservation</h1>
        </div>
    </div>
    <div class="p-5">
        <div class="grid">
            <form action="{{ $submit }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-10 bg-white shadow-lg rounded-lg p-8 auto-rows-max">
                    <div class="grid gap-3">
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Customer Name: <span
                                    class="text-red-600">*</span></label>
                            <div class="mt-2">
                                @if ($title == 'Edit')
                                    <b> {{ $reservation->customer->name }}</b>
                                    <select name="" id="select-beast" class="hidden"></select>
                                @else
                                    <select id="select-beast" placeholder="Select a person..." autocomplete="off"
                                        name="customer_id" class="search_user">
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Number of People: <span
                                    class="text-red-600">*</span></label>
                            <input type="number" name="number_of_people"
                                class="block w-full text-sm rounded-lg border-gray-400" required
                                value="{{ @$reservation->reservation_total_guest }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Remarks: </label>
                            <textarea name="remarks"
                                class="block w-full text-sm rounded-lg border-gray-400 p-3 h-20">{{ @$reservation->reservation_remarks }}</textarea>
                        </div>
                    </div>
                    <div class="grid gap-3">
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Date: <span
                                    class="text-red-600">*</span></label>
                            <input type="date" name="reservation_date"
                                class="block w-full text-sm rounded-lg border-gray-400" required
                                value="{{ @$reservation->reservation_date }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Time: <span
                                    class="text-red-600">*</span></label>
                            <input type="time" name="reservation_time"
                                class="block w-full text-sm rounded-lg border-gray-400" required
                                value="{{ @$reservation->reservation_time }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="inline-block mb-3">Reservation Status: <span
                                    class="text-red-600">*</span></label>
                            <select name="reservation_status" class="block w-full text-sm rounded-lg border-gray-400 p-3">
                                @foreach ($reservation_status as $key => $status)
                                    <option value="{{ $key }}" @if (@$reservation->reservation_status == $key) selected @endif>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="grid gap-10 bg-white shadow-lg rounded-lg p-8 mt-5">
                    <div class="grid gap-3">
                        <div class="mb-3">
                            <label for="" class="font-bold">Orders</label>
                            <div class="mt-3">
                                <table class="w-full">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th class="px-6 py-3">#</th>
                                            <th class="px-6 py-3">Menu</th>
                                            <th class="px-6 py-3">Quantity</th>
                                            <th class="px-6 py-3">Price</th>
                                            <th class="px-6 py-3">Total</th>
                                            <th class="px-6 py-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($title == 'Edit' && $reservation->order)
                                            @foreach ($reservation->order as $key => $order)
                                                <tr>
                                                    <td
                                                        class='px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap'>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td class='text-center'>
                                                        {{ $order->menu->name }}
                                                        <input type='hidden' name='menu_id[]'
                                                            value='{{ $order->menu_id }}'>
                                                    </td>
                                                    <td class='text-center'>
                                                        <input type='number' name='quantity[]'
                                                            class='w-full text-sm rounded-lg border-gray-400 text-center'
                                                            id='cal_total_price' value="{{ @$order->order_quantity }}">
                                                    </td>
                                                    <td class='text-center'>
                                                        RM {{ $order->menu->price }}
                                                        <input type="hidden" id="price"
                                                            value="{{ $order->menu->price }}">
                                                    </td>
                                                    <td class='text-center'>
                                                        <input type='number' id='total_price' readonly
                                                            class='w-1/2 text-center text-sm rounded-lg border-none total_price'
                                                            value="{{ @$order->order_price }}">
                                                    </td>
                                                    <td class='text-center'>
                                                        <button type='button' id='delete_order'
                                                            class='bx bx-trash text-xl text-red-400'></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr id="insert_b4"></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex">
                                <div class="flex mt-5 w-1/2 items-center">
                                    <select name="" id="add_order"
                                        class="block w-full text-sm rounded-lg border-gray-400 mr-3"></select>
                                    <button type="button"
                                        class="add_order_btn px-3 py-2.5 bg-blue-500 text-white rounded-lg text-sm w-1/2">
                                        Add
                                    </button>
                                </div>
                                <div class="w-1/2 text-center mt-5 font-bold border-t p-3 items-center">
                                    Total:
                                    <span id="subtotal"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (@$reservation->reservation_payment_slip)
                    <div class="grid bg-white shadow-lg rounded-lg p-8 mt-5">
                        <label for="" class="font-bold text-2xl">Payment Slip</label>
                        <a href="{{ $get_reservation_media }}" class="mt-5" target="_blank">View Payment</a>
                    </div>
                @endif
                <div class="grid gap-10 bg-white shadow-lg rounded-lg p-8 mt-5">
                    <div class="mb-3">
                        <button class="px-3 py-2.5 bg-blue-600 text-white rounded-lg" type="submit">Submit</button>
                        <a href="{{ route('reservation_listing') }}"
                            class="px-3 py-2 bg-gray-600 text-white rounded-lg">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#select-beast", {
            valueField: 'id',
            labelField: 'label',
            searchField: 'label',
            // fetch remote data
            load: function(query, callback) {

                $.ajax({
                    url: "{{ route('ajax_get_customer') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "customer_name": query
                    },
                    success: (json) => {
                        // console.log(json);
                        callback(json.list);
                    },
                    error: (e) => {
                        console.log(e);
                        callback();
                    }
                })
            },
        });

        var add_order = new TomSelect("#add_order", {
            valueField: 'id',
            labelField: 'label',
            searchField: 'label',
            // fetch remote data
            load: function(query, callback) {

                $.ajax({
                    url: "{{ route('ajax_get_menu') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "menu_name": query
                    },
                    success: (json) => {
                        // console.log(json);
                        callback(json.result);
                    },
                    error: (e) => {
                        console.log(e);
                        callback();
                    }
                })
            },
        });

        let order_count = "{{ count($reservation->order) ?? 0 }}";
        let menu_id = null;

        $(document).ready(function() {
            $('.add_order_btn').prop('disabled', true)
            calculate_total_sum()
        })

        $(document).on('change', '#add_order', function() {
            menu_id = $('#add_order').val();
            // console.log(menu_id);
            if (!menu_id) {
                $('.add_order_btn').prop('disabled', true)
            } else {
                $('.add_order_btn').prop('disabled', false)
            }
        })

        $(document).on('click', '.add_order_btn', () => {
            // console.log(menu_id);
            $.ajax({
                url: "{{ route('ajax_get_menu_details') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "menu_id": menu_id,
                },
                success: (s) => {
                    // console.log(s);
                    order_count++;
                    let order = "";

                    order +=
                        "<tr><td class='px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap text-center'>" +
                        order_count + "</td>";
                    order += "<td class='text-center'>" + s.name +
                        "<input type='hidden' name='menu_id[]' value='" + s.id + "' ></td>";
                    order +=
                        "<td><input type='number' name='quantity[]' class='w-full text-sm rounded-lg border-gray-400 text-center' id='cal_total_price'></td>";
                    order += "<td class='text-center'>RM " + s.price.toFixed(2) +
                        " <input type='hidden' id='price' value='" + s.price + "'></td>"
                    order +=
                        "<td class='text-center'><input type='number' id='total_price' readonly class='w-1/2 text-center text-sm rounded-lg border-none total_price'></td>"
                    order +=
                        "<td class='text-center'><button type='button' id='delete_order' class='bx bx-trash text-xl text-red-400'></button></td></tr>";

                    $(order).insertBefore("#insert_b4");
                    add_order.clear();
                },
                error: (e) => {
                    console.log(e);
                }
            });

        })

        $(document).on('click', '#delete_order', function() {
            $(this).parent().parent().remove();
            calculate_total_sum();
        });

        $(document).on('keyup', '#cal_total_price', function() {
            let quantity = $(this).val();
            let price = $(this).parent().parent().find('input#price').val();
            total_price = quantity * price;
            // console.log(total_price);
            $(this).parent().parent().find('input#total_price').val(total_price);
            calculate_total_sum();
        });

        let total_sum = 0;

        function calculate_total_sum() {
            total_sum = $('.total_price').map((_, el) => el.value).get();
            // console.log(total_sum);
            let price = total_sum.reduce((p, c) => {
                return p + (parseFloat(c) || 0);
            }, 0);
            $('#subtotal').html('RM ' + price.toFixed(2));
        }
    </script>
@endsection
