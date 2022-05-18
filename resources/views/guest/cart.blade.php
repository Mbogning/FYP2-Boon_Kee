@extends('welcome')
@section('title', 'Cart')
@section('content')
    <div class="min-h-screen">
        <div class="p-5 sm:p-10 min-h-screen">
            <div class="pt-[5.75rem]">
                <div class="sm:px-20 2xl:px-40 py-5 sm:py-10">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-xl">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 grid sm:table">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 hidden sm:table-header-group">
                                <tr>
                                    <th></th>
                                    <th class="px-6 py-3">Description</th>
                                    <th class="px-6 py-3 text-center">Quantity</th>
                                    <th class="px-6 py-3 text-center">Remove</th>
                                    <th class="px-6 py-3 text-center">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $a = 3;
                                    $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
                                @endphp
                                @if (!empty($cart) && $cart->isNotEmpty())
                                    @foreach ($cart as $key => $item)
                                        <tr class="bg-white border-b dark:bg-zinc-700 dark:border-gray-500 grid sm:table-row grid-cols-3"
                                            data-menuid="{{ $item->menu_id }}">
                                            <td class="px-6 py-5 font-medium text-gray-900 dark:text-white">
                                                <img src="{{ $menu[$item->menu_id]['img'] }}" alt=""
                                                    class="rounded-lg" width="200px">
                                            </td>
                                            <td class="px-6 py-5 font-medium text-gray-900 dark:text-white col-span-2">
                                                <a
                                                    href="{{ route('view_menu_info', $menu[$item->menu_id]['menu']->slug) }}">
                                                    <b class="text-xl">
                                                        {{ $menu[$item->menu_id]['menu']->name }}
                                                    </b>
                                                </a>
                                                <br>
                                                <span
                                                    class="text-xs overflow-hidden w-[20rem] max-w-[5ch] sm:max-w-full sm:line-clamp-1 ">
                                                    {!! $menu[$item->menu_id]['menu']->description !!}
                                                </span>
                                                <input type="hidden" class="menu_price"
                                                    value="{{ $menu[$item->menu_id]['menu']->price }}">
                                            </td>
                                            <td
                                                class="px-6 py-5 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                <div
                                                    class="flex flex-row h-10 rounded-lg relative bg-transparent mt-1 justify-center">
                                                    <button data-action="decrement"
                                                        class=" bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-10 rounded-l cursor-pointer outline-none">
                                                        <span class="m-auto text-2xl font-thin">−</span>
                                                    </button>
                                                    <input type="number"
                                                        class="w-1/4 outline-none focus:outline-none text-center bg-gray-200 border-none font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700 p-0"
                                                        name="custom-input-number" value="{{ $item->order_quantity }}">
                                                    <button data-action="increment"
                                                        class="bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-10 rounded-r cursor-pointer">
                                                        <span class="m-auto text-2xl font-thin">+</span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-5 font-medium text-gray-900 dark:text-white whitespace-nowrap text-center">
                                                <button
                                                    class="p-2 sm:px-5 sm:py-3 text-red-400 border border-red-400 rounded-md hover:bg-red-400 hover:text-white hover:shadow-md remove_cart_btn">x</button>
                                            </td>
                                            <td class="px-6 py-5 font-medium text-gray-900 dark:text-white whitespace-nowrap text-center col-start-2 row-start-2 flex sm:table-cell items-center"
                                                id="total_sum_{{ $item->menu_id }}">
                                            </td>
                                            <input type="hidden" class="total_sum"
                                                id="total_sum_input_{{ $item->menu_id }}">
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div class="p-5 dark:text-white">
                                                No Item in Cart 
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 border-t">
                        <div class="flex justify-between p-5">
                            <div class="dark:text-white">Total:</div>
                            <div id="subtotal" class="dark:text-white font-bold"></div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="flex justify-end p-5">
                            <form action="{{ route('cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="total_sum" id="total_sum_input">
                                <button class="bg-amber-300 p-3 rounded-lg hover:shadow-md duration-150 hover:rounded-none">
                                    Proceed to checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            calculate_sum_price()
            calculate_grandtotal()
        })

        $(document).on('click', 'button[data-action="increment"]', function() {
            let value = $(this).parent().find('input[type="number"]').val();
            value++;
            $(this).parent().find('input[type="number"]').val(value);
            let menu_price = $(this).parent().parent().parent().find('td input.menu_price').val();
            let menu_id = $(this).parent().parent().parent().data('menuid');
            $(this).parent().parent().parent().find('td#total_sum_' + menu_id).html('RM ' + (menu_price * value)
                .toFixed(2))
            $(this).parent().parent().parent().find('.total_sum').val(menu_price * value)

            update_cart(menu_id, value)
            calculate_grandtotal()
        })

        $(document).on('click', 'button[data-action="decrement"]', function() {
            let value = $(this).parent().find('input[type="number"]').val();
            if (value > 0) {
                value--;
            }
            if (value == 0) {
                if (confirm("Are you sure you want to remove it?")) {
                    $(this).parent().parent().parent().remove()
                } else {
                    value++
                }
            }
            $(this).parent().find('input[type="number"]').val(value);
            let menu_price = $(this).parent().parent().parent().find('td input.menu_price').val();
            let menu_id = $(this).parent().parent().parent().data('menuid');
            $(this).parent().parent().parent().find('td#total_sum_' + menu_id).html('RM ' + (menu_price * value)
                .toFixed(2))
            $(this).parent().parent().parent().find('.total_sum').val(menu_price * value)

            update_cart(menu_id, value)
            calculate_grandtotal()
        })

        $(document).on('click', '.remove_cart_btn', function() {
            let confirm_delete = confirm("Are you sure you want to remove it?")

            if (confirm_delete) {
                $(this).parent().parent().remove()
                let menu_id = $(this).parent().parent().data('menuid');
                update_cart(menu_id, 0)
                calculate_grandtotal()
            }
        })

        function calculate_sum_price() {
            var arr = [];

            $('table').find('tr td input.menu_price').each(function() {
                let menu_id = $(this).parent().parent().data('menuid');

                let menu_price = $(this).val();
                let quantity = $(this).parent().parent().find('td div input[name="custom-input-number"]')
                    .val()
                let sum = menu_price * quantity;

                $(this).parent().parent().parent().find('#total_sum_' + menu_id).html('RM ' + sum.toFixed(2));
                $(this).parent().parent().parent().find('#total_sum_input_' + menu_id).val(sum.toFixed(2));
            })
        }

        function update_cart(menu_id, value = 0) {
            $.ajax({
                url: "{{ route('ajax_update_cart') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "menu_id": menu_id,
                    "quantity": value,
                    "total_sum": $('#total_sum_input').val()
                },
                success: (s) => {
                    console.log(s);
                },
                error: (e) => {

                }
            })
        }

        function calculate_grandtotal() {
            total_sum = $('.total_sum').map((_, el) => el.value).get();
            // console.log(total_sum);
            let price = total_sum.reduce((p, c) => {
                return p + (parseFloat(c) || 0);
            }, 0);
            $('#subtotal').html('RM ' + price.toFixed(2));
            $('#total_sum_input').val(price.toFixed(2));
        }
    </script>
@endsection
