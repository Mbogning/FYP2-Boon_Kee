<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Orders;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function listing(Request $request)
    {
        $search = null;
        $reservations = Reservation::get_records($search);

        return view('reservation.listing', [
            'reservations' => $reservations
        ]);
    }

    public function add(Request $request)
    {
        $reservation = null;
        $validation = null;

        if ($request->isMethod('post')) {
            // dd($request->all());
            $validation = Validator::make($request->all(), [
                'customer_id' => 'required',
                'number_of_people' => 'required',
                'remarks' => 'nullable|max:100',
                'reservation_date' => 'required',
                'reservation_time' => 'required',
                'reservation_status' => 'required'
            ]);

            if (!$validation->fails()) {
                $customer = User::find($request->input('customer_id'));

                $reservation = Reservation::create([
                    'customer_id' => $request->input('customer_id'),
                    'reservation_total_guest' => $request->input('number_of_people'),
                    'reservation_remarks' => $request->input('remarks') ?? '',
                    'reservation_date' => $request->input('reservation_date'),
                    'reservation_time' => $request->input('reservation_time'),
                    'reservation_status' => $request->input('reservation_status'),
                    'reservation_total_amount' => 0,
                ]);

                $menus = $request->input('menu_id');
                $quantities = $request->input('quantity');
                $total_amount = 0;

                for ($i = 0; $i < count($menus); $i++) {

                    $menu = Menus::find($menus[$i]);

                    Orders::create([
                        'reservation_id' => $reservation->id,
                        'menu_id' => $menus[$i],
                        'order_quantity' => $quantities[$i],
                        'order_price' => $menu->price * $quantities[$i],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $total_amount += $menu->price * $quantities[$i];
                }

                $reservation->update([
                    'reservation_total_amount' => $total_amount,
                    'updated_at' => now()
                ]);

                Session::flash('success', 'Successfully created a new reservation for ' . $customer->name);
                return redirect()->route('reservation_listing');
            }
        }

        return view('reservation.form', [
            'title' => 'Add',
            'submit' => route('reservation_add'),
            'reservation' => $reservation,
            'reservation_status' => ['' => 'Please Select Status', 'Pending' => 'Pending', 'Arrived' => 'Arrived', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Deleted' => 'Deleted']
        ])->withErrors($validation);
    }

    public function edit(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $validation = null;

        if (!$reservation) {
            Session::flash('error', 'Invalid Reservation');
            return redirect()->route('reservation_listing');
        }

        if ($request->isMethod('post')) {
            // dd($request->all());
            $reservation->update([
                'reservation_total_guest' => $request->input('number_of_people'),
                'reservation_remarks' => $request->input('remarks') ?? '',
                'reservation_date' => $request->input('reservation_date'),
                'reservation_time' => $request->input('reservation_time'),
                'reservation_status' => $request->input('reservation_status'),
            ]);

            $menus = $request->input('menu_id');
            $old_order = Orders::get_all_order_by_reservation($id);
            $remove_order = array_diff($old_order, $menus);

            $quantities = $request->input('quantity');
            $total_amount = 0;

            for ($i = 0; $i < count($menus); $i++) {

                $menu = Menus::find($menus[$i]);

                if ($menu) {

                    $check_order = Orders::get_order_by_reservation_menu($id, $menus[$i]);

                    if ($check_order) {

                        $order = Orders::find($check_order->id);

                        $order->update([
                            'order_quantity' => $quantities[$i],
                            'order_price' => $menu->price * $quantities[$i],
                            'updated_at' => now()
                        ]);

                        $total_amount += $menu->price * $quantities[$i];
                    } else {

                        Orders::create([
                            'reservation_id' => $id,
                            'menu_id' => $menus[$i],
                            'order_quantity' => $quantities[$i],
                            'order_price' => $menu->price * $quantities[$i],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);

                        $total_amount += $menu->price * $quantities[$i];
                    }
                }
            }

            if ($remove_order) {
                // dd($remove_order);
                foreach ($remove_order as $remove_key => $remove) {
                    Orders::query()->where('menu_id', $remove)->where('reservation_id', $id)->delete();
                }
            }

            $update_total_amount = Reservation::find($id);
            $update_total_amount->update([
                'reservation_total_amount' => $total_amount,
                'updated_at' => now()
            ]);

            Session::flash('success', 'Successfuly updated reservation for ' . $reservation->customer->name);
            return redirect()->route('reservation_listing');
        }

        return view('reservation.form', [
            'title' => 'Edit',
            'submit' => route('reservation_edit', $id),
            'reservation' => $reservation,
            'reservation_status' => ['' => 'Please Select Status', 'Pending' => 'Pending', 'Arrived' => 'Arrived', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Deleted' => 'Deleted']
        ])->withErrors($validation);
    }

    public function delete(Request $request)
    { }

    // TODO Staff Manage Reservation
    public function update_status(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $validation = null;

        if (!$reservation) {
            Session::flash('error', 'Invalid Reservation. ');
            return redirect()->route('reservation_listing');
        }

        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'reservation_status' => 'required'
            ]);

            if (!$validation->fails()) {
                $reservation->update([
                    'reservation_status' => $request->input('reservation_status'),
                    'updated_at' => now()
                ]);

                Session::flash('success', 'Successfully updated reservation for ' . $reservation->customer->name);
                return redirect()->route('reservation_listing');
            }
        }

        return view('reservation.update', [
            'title' => 'Edit',
            'submit' => route('reservation_update', $id),
            'reservation' => $reservation,
            'reservation_status' => ['' => 'Please Select Status', 'Pending' => 'Pending', 'Arrived' => 'Arrived', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Deleted' => 'Deleted']
        ])->withErrors($validation);
    }

    // TODO Customer Reservation
    public function add_reservation_cus(Request $request)
    { }
}
