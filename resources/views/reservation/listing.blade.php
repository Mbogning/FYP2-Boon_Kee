@extends('layouts.sidebar')
@section('title')
    Resevation Listing
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
    <div class="p-5">
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div>
                <h1 class="font-bold flex justify-start items-center">
                    Reservation listing
                    @can('reservation_add')
                        <a href="{{ route('reservation_add') }}"
                            class="border border-green-500 text-green-500 hover:bg-green-500 hover:text-white py-1.5 px-3 rounded-md ml-2 text-xs items-center flex justify-center">
                            <i class="bx bx-plus bx-xs mr-1"></i> ADD
                        </a>
                    @endcan
                </h1>
            </div>
        </div>
    </div>
    <div x-data="{ open: false }">
        <div class="p-5">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Items</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($reservations->isNotEmpty())
                            {{-- @dd($reservations) --}}
                            @foreach ($reservations as $key => $reservation)
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
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $reservations->firstItem() + $key }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <b>{{ $reservation->customer->name }}</b><br>
                                        Guest: <p class="inline">{{ $reservation->reservation_total_guest }}</p>
                                        <br>
                                        <b>Special Remarks: </b><br>
                                        <span>
                                            {{ $reservation->reservation_remarks }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($reservation->order)
                                            @foreach ($reservation->order as $order)
                                                {{ $order->menu->name }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ date_format($reservation->created_at, 'Y-m-d H:i A') }}<br>
                                        {!! $status !!}<br>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @role('Admin')
                                            <a href="{{ route('reservation_edit', $reservation->id) }}"
                                                class="border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                                Edit
                                            </a>
                                            @elserole('Cashier')
                                            <a href="{{ route('reservation_payment', $reservation->id) }}"
                                                class="border border-green-500 text-green-500 hover:text-white hover:bg-green-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                                View Payment
                                            </a>
                                        @else
                                            <a href="{{ route('reservation_update', $reservation->id) }}"
                                                class="border border-amber-500 text-amber-500 hover:text-white hover:bg-amber-500 px-3 py-1.5 text-center text-xs font-medium rounded-md mr-2 mb-2">
                                                Edit
                                            </a>
                                        @endrole
                                        <button type="button" id="delete" aria-expanded="false" aria-haspopup="true"
                                            @click="open = !open" data-id="{{ $reservation->id }}"
                                            class="text-red-500 hover:text-white border border-red-500 hover:bg-red-500 font-medium rounded-md text-xs px-3 py-1.5 text-center mr-2 mb-2">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center p-5" colspan="5">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {!! $reservations->links() !!}
            </div>
        </div>
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="user-menu-buttoe" role="dialog" aria-modal="true"
            x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    @click="open = !open"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: outline/exclamation -->
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Reservation
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete? </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form action="{{ route('reservation_delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reservation_id" id="reservation_id">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                            <button type="button" @click="open = !open"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '#delete', function() {
            // console.log($(this).data('id'));
            $('#reservation_id').val($(this).data('id'));
        })
    </script>
@endsection
