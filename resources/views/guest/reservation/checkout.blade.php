@extends('welcome')
@section('title', 'Checkout - Reservation')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/vanilla-calendar.css') }}">
@endsection
@section('content')
    <div class="min-h-screen">
        <div class="p-5 sm:p-10 min-h-screen">
            <form action="{{ $submit }}" method="post">
                @csrf
                <div class="sm:p-20 grid gap-10">
                    <div class="grid gap-10">
                        <div>
                            <h1 class="text-3xl text-yellow-500 font-bold">Reservation Info</h1>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-10">
                            <div class="grid grid-cols-4 gap-10 p-5 bg-white dark:bg-zinc-700 dark:text-white rounded-xl shadow-lg">
                                <div class="col-span-1">
                                    <div class="p-10 rounded-lg bg-zinc-200"></div>
                                </div>
                                <div class="col-span-3 grid items-center">
                                    <div class="block">{{ $customer->name }}</div>
                                    <div class="block">{{ $customer->phone }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-5">
                        <div class="font-bold dark:text-white">Date & Time</div>
                        <div class="sm:flex flex-row">
                            <div class="bg-white dark:bg-zinc-700 basis-1/2 p-3 sm:p-10 rounded-lg shadow-lg sm:mr-10">
                                <div id="v-cal">
                                    <div class="vcal-header">
                                        <button class="vcal-btn" data-calendar-toggle="previous">
                                            <svg height="24" version="1.1" viewbox="0 0 24 24" width="24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z">
                                                </path>
                                            </svg>
                                        </button>

                                        <div class="vcal-header__label" data-calendar-label="month">
                                            March 2017
                                        </div>

                                        <button class="vcal-btn" data-calendar-toggle="next">
                                            <svg height="24" version="1.1" viewbox="0 0 24 24" width="24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="vcal-week">
                                        <span>Mon</span> <span>Tue</span><span>Wed</span> <span>Thu</span> <span>Fri</span>
                                        <span>Sat</span> <span>Sun</span>
                                    </div>
                                    <div class="vcal-body" data-calendar-area="month"></div>
                                </div>
                                <input type="hidden" name="selected_date" id="selected_date" data-calendar-label="picked">
                            </div>
                            <div class="basis-1/2 mt-10 sm:mt-0 sm:ml-10">
                                <div class="grid gap-3 grid-cols-3 mb-5">
                                    @if ($times)
                                        @php
                                            $list_time = explode(',', $times->setting_value);
                                        @endphp
                                        @foreach ($list_time as $time)
                                            <div class="p-5 bg-white dark:bg-zinc-700 dark:text-white rounded-lg font-bold text-center hover:shadow-lg border cursor-pointer"
                                                data-time="{{ $time }}" data-time-select="false">
                                                {{ date('h:i A', strtotime($time)) }}
                                            </div>
                                        @endforeach
                                    @endif
                                    <input type="hidden" name="selected_time" id="selected_time">
                                </div>
                                <div class="grid gap-5">
                                    <div class="dark:text-white">Guests</div>
                                    <div class="p-3 bg-white rounded-lg text-center flex justify-between sm:w-3/4">
                                        <button class="p-5 bg-zinc-300 rounded-md" type="button"
                                            data-type="minus">-</button>
                                        <div class="flex items-center justify-center">
                                            <input type="number" name="guest_number" id="guest_number"
                                                class="w-1/4 border-0" value="1" readonly>
                                            Guest
                                        </div>
                                        <button class="p-5 bg-zinc-300 rounded-md" type="button" data-type="plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <label for="" class="mb-3 dark:text-white">Remarks: </label>
                        <div class="">
                            <textarea name="reservation_remarks" rows="10" class="w-full p-3 border border-gray-300 rounded-md shadow-md"
                                placeholder="This field is optional"></textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="px-6 py-3 bg-yellow-300 text-zinc-700 font-bold rounded-2xl hover:shadow-md"
                            id="next_btn">
                            Next
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/vanilla-calendar.js') }}"></script>
    <script>
        let set_date = '';

        window.onload = (e) => {
            vanillaCalendar.init({
                disablePastDays: true
            });
        }

        $(document).ready(function() {
            $('#next_btn').hide()
        })

        $('button[type="button"]').click(function() {
            let guest_number = $('#guest_number').val();
            if ($(this).data('type') == 'minus') {
                if (guest_number != 1) {
                    guest_number--;
                }
                $('#guest_number').val(guest_number)
            } else {
                guest_number++;
                $('#guest_number').val(guest_number)
            }
        })

        // select time function 
        $(document).on('click', '[data-time-select]', function() {
            $(this).attr('data-time-select', 'true')
            $(this).addClass('border-yellow-400 shadow-lg');

            $('div[data-time-select]').not($(this)).removeClass('border-yellow-400 shadow-lg')

            $('#selected_time').val($(this).data('time'))
        })

        $(document).on('click', function() {
            let selected_date = $('#selected_date').val()
            let selected_time = $('#selected_time').val()

            if (selected_date.length != 0 && selected_time.length != 0) {
                $('#next_btn').show()
            } else {
                $('#next_btn').hide()
            }
        })
    </script>
@endsection
