<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    @if (Session::has('success'))
        <div class="py-3">
            <div class=" bg-green-200 text-green-800 border-green-900 py-3 px-5 rounded-lg">
                <span class="font-bold">
                    {{ session::get('success') }}
                </span>
            </div>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="py-3">
            <div class=" bg-red-300 text-red-800 border-red-900 py-3 px-5 rounded-lg">
                <span class="font-bold">
                    {{ session::get('error') }}
                </span>
            </div>
        </div>
    @endif
    <div class="h-[90%]">
        <div class="bg-white p-20 rounded-2xl shadow-lg">
            <div id="calendar"></div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="popup-modal" tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 bg-gray-500/75 hidden">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto mx-auto top-[40%]">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-end p-2">
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="popup-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 pt-0 text-center">
                    <form action="{{ route('insert_working_schedule') }}" method="post">
                        @csrf
                        <h1 id="details" class="mb-5"></h1>
                        <table class="mx-auto p-3 mb-5">
                            <tbody id="select_date">

                            </tbody>
                        </table>
                        <input type="hidden" name="work_date" id="work_date">
                        <div>
                            <div class="mb-2">
                                <label for="">Role: </label>
                                <select name="user_role_id" id="user_role_id" class="text-sm">
                                    @foreach ($roles as $key => $role)
                                        <option value="{{ $key }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2" id="user_list">
                                <label for="">User: </label>
                                <select name="user_id" id="user" class="text-sm"></select>
                            </div>
                            <div class="mb-2" id="status_list">
                                <label for="">Status: </label>
                                <select name="status" id="" class="text-sm">
                                    <option value="">Please Select Status </option>
                                    <option value="active">Active</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <button data-modal-toggle="popup-modal" type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 disabled:bg-blue-400">
                            Yes, I'm sure
                        </button>
                        <button data-modal-toggle="popup-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No,
                            cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dateClick: function(info) {
                    $("#details").html('');
                    $("#work_date").val();
                    $("#select_date").html('')
                    $("#popup-modal").fadeIn('fast').show();
                    search_date(info.dateStr);
                },
                events: [
                    @foreach ($all_schedule as $schedule)
                        {
                        title: "{{ $schedule->user->name }}",
                        start: "{{ $schedule->work_date }}"
                        },
                    @endforeach
                ]
            });

            calendar.render();
        });

        function search_date(date) {
            $.ajax({
                url: "{{ route('working_schedule') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date": date
                },
                success: function(data) {
                    console.log(data);
                    $("#details").html(data.date);
                    $("#work_date").val(data.date);
                    let work_detail = "";
                    if (data.result.length > 0) {
                        data.result.forEach((info) => {
                            work_detail += "<tr><td class='px-3'>" + info.role.name + "</td><td>" + info.user.name +
                                "</td></tr>";
                        });

                        $("#select_date").html(work_detail)
                    }
                },
                error(err) {
                    console.log(err);
                }
            })
        }

        $(document).ready(function() {
            $('[data-modal-toggle="popup-modal"]').click(function() {
                $("#popup-modal").fadeOut().hide();
            });

            $('#user_list').hide();
            $('#status_list').hide();
            $('button[type="submit"]').attr('disabled', 'disabled')
        })

        $('#user_role_id').on('change', function() {
            $.ajax({
                url: "{{ route('ajax_user_roles') }}",
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "role": $(this).val()
                },
                success(data) {
                    if (data.data != null && data.status == 'true') {
                        // console.log(data);
                        $('#user_list').show();
                        $('#status_list').show();
                        let option = "";
                        for (var i in data.data) {
                            option += "<option value='" + i + "'>" + data.data[i] + "</option>"
                        }
                        $('#user').html(option)
                        $('button[type="submit"]').removeAttr('disabled')
                    } else {
                        $('#user_list').hide();
                        $('#status_list').hide();
                        $('button[type="submit"]').attr('disabled', 'disabled')
                    }
                },
                error(err) {
                    console.log(err);
                }
            })
        })
    </script>
</body>

</html>
