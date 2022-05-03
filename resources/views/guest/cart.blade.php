@extends('welcome')
@section('title', 'Cart')
@section('content')
    <div class="min-h-screen">
        <div class="p-5 sm:p-10 min-h-screen">
            <div class="pt-[5.75rem]">
                <div class="sm:px-20 2xl:px-40 py-5 sm:py-10">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                                @if (!empty($cart))
                                    @foreach ($cart as $key => $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 grid sm:table-row grid-cols-3"
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
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Item in Cart</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 border-t">

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
        })

        $(document).on('click', 'button[data-action="increment"]', function() {
            let value = $(this).parent().find('input[type="number"]').val();
            value++;
            $(this).parent().find('input[type="number"]').val(value);
            let menu_price = $(this).parent().parent().parent().find('td input.menu_price').val();
            let menu_id = $(this).parent().parent().parent().data('menuid');
            $(this).parent().parent().parent().find('td#total_sum_' + menu_id).html('RM ' + (menu_price * value)
                .toFixed(2))

            update_cart(menu_id, value)
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

            update_cart(menu_id, value)
        })

        $(document).on('click', '.remove_cart_btn', function() {
            let confirm_delete = confirm("Are you sure you want to remove it?")

            if (confirm_delete) {
                $(this).parent().parent().remove()
                let menu_id = $(this).parent().parent().data('menuid');
                update_cart(menu_id, 0)
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
            })
        }

        function update_cart(menu_id, value = 0) {
            $.ajax({
                url: "{{ route('ajax_update_cart') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "menu_id": menu_id,
                    "quantity": value
                },
                success: (s) => {
                    console.log(s);
                },
                error: (e) => {

                }
            })
        }
    </script>
@endsection
