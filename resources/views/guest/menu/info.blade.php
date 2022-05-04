@extends('welcome')
@section('title', $menu->name)
@section('head')

@endsection
@section('content')
    @php
    $url = 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Good_Food_Display_-_NCI_Visuals_Online.jpg';
    @endphp
    <div class="grid px-5 sm:px-20 2xl:px-40 min-h-screen">
        {{-- Hero --}}
        <div class="h-full">
            <div class="mt-20">
                <img src="{{ $menu_img ?? $url }}" alt="" class="w-full bg-fixed rounded-b-xl">
            </div>
        </div>
        {{-- Description --}}
        <div class="pt-5 sm:p-10 sm:relative sm:bg-white sm:rounded-xl sm:-top-20 sm:w-3/4 sm:mx-auto sm:shadow-lg">
            <div>
                <div class="mb-5 flex justify-between items-center">
                    <h1 class="text-2xl sm:text-5xl font-bold">{{ $menu->name }}</h1>
                    <button
                        class="hidden sm:flex items-center py-2 px-3 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs sm:text-sm add_to_cart_btn"
                        data-id="{{ $menu->id }}" @if (@$cart[$menu->id]) disabled @endif>
                        <i class='bx bx-check-circle {{ @$cart[$menu->id] ? 'block' : 'hidden' }}'>
                        </i>
                        <i class='bx bx-cart-add {{ @$cart[$menu->id] ? 'hidden' : 'block' }} '>
                        </i>
                    </button>
                </div>
                <div class="mb-5">
                    <p class="text-md">
                        Price : <b>RM {{ number_format($menu->price, 2) }}</b>
                    </p>
                </div>
                <div class="mb-5 text-justify">
                    {!! $menu->description !!}
                </div>
            </div>
        </div>
        <div class="sm:p-10 sm:hidden mt-5">
            <button
                class="w-full items-center p-3 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs sm:text-sm add_to_cart_btn"
                data-id="{{ $menu->id }}" @if (@$cart[$menu->id]) disabled @endif>
                <span id="add_to_cart_txt">
                    @if (@$cart[$menu->id])
                        <a href="{{ route('cart') }}">In Cart</a>
                    @else
                        Add to cart
                    @endif
                </span>
            </button>
        </div>
        {{-- More foods --}}
        <div class="py-5 max-w-[20rem] sm:max-w-xl">
            <div class="mb-5">
                <h1 class="text-xl font-bold">
                    More Food
                </h1>
            </div>
            <div class="flex overflow-x-auto snap-x">
                @foreach ($more_menu as $more)
                    <div class="sm:mr-3 flex-none p-5 w-1/2 snap-center hover:scale-105 duration-200">
                        <a href="{{ route('view_menu_info', $more->slug) }}">
                            <img src="{{ @$imgs[$more->slug] ?? $url }}" class="rounded-xl brightness-75" />
                        </a>
                        <p
                            class="text-xs -translate-y-6 text-white font-semibold sm:-translate-y-8 sm:text-base translate-x-3">
                            {{ $more->name }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '.add_to_cart_btn', function() {
            let menu_id = $(this).data('id');
            @if (auth()->check())
                add_to_cart(menu_id);
            @else
                window.location.href = "{{ route('login') }}"
            @endif
        })

        function add_to_cart(menu_id) {
            $.ajax({
                url: "{{ route('ajax_add_to_cart') }}",
                method: "Post",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'menu_id': menu_id
                },
                success: (s) => {
                    $('button[data-id="' + menu_id + '"]').prop('disabled', true)
                    $('button[data-id="' + menu_id + '"]').find('.bx-cart-add').hide()
                    $('button[data-id="' + menu_id + '"]').find('.bx-check-circle').show()
                    $('#add_to_cart_txt').html('In cart')
                },
                error: (e) => {
                    console.log(e);
                }
            })
        }
    </script>
@endsection
