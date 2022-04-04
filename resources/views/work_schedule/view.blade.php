@extends('layouts.sidebar')
@section('title')
    Working Schedule
@endsection
@section('breadcrumb')
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="" class="">Application</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="" class="breadcrumb--active">Working Schedule</a>
    </div>
    <!-- END: Breadcrumb -->
@endsection
@section('content')
    <div class="my-5">
        <h1 class="text-5xl font-bold">Working Schedule</h1>
    </div>
    <div >
        <div class="bg-white p-20 rounded-2xl shadow-lg">
            <div id="calendar"></div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    
                },
                events: [
                    @foreach ($work_schedule as $schedule)
                        {
                        title: "{{ $schedule->user->name }}",
                        start: "{{ $schedule->work_date }}"
                        },
                    @endforeach
                ]
            });

            calendar.render();
        });
    </script>
@endsection
