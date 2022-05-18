@extends('welcome')
@section('title', 'Confirmation - Reservation')
@section('head')

@endsection
@section('content')
    <div class="min-h-screen">
        <div class="p-10">
            <div class="grid mt-14 sm:mt-16 text-center">
                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_lk80fpsm.json" background="transparent"
                    speed="1" style="width: 300px; height: 300px;" class="mx-auto" autoplay>
                </lottie-player>
                <div class="grid gap-10 p-5">
                    <h1 class="text-green-500 text-3xl font-bold">Reservation Successful</h1>
                    <p class="font-bold text-sm sm:text-base dark:text-white">Page will be redirect back to main page in <span
                            id="count_down"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let counter = 10;
        $(document).ready(function() {
            window.onload = () => {
                setTimeout(() => {
                    window.location.href = "{{ route('welcome') }}"
                }, 10000);

                setInterval(() => {
                    $('#count_down').html(counter)
                    if (counter != 0) {
                        counter--;
                    }
                }, 1000);
            }
        })
    </script>
@endsection
