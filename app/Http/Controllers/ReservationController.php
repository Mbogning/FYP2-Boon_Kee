<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Orders;
use App\Models\Reservation;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
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
            'reservation_status' => ['' => 'Please Select Status', 'Pending' => 'Pending', 'Paid' => 'Paid', 'Arrived' => 'Arrived', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Deleted' => 'Deleted'],
            'get_reservation_media' => Reservation::get_reservation_media($id)
        ])->withErrors($validation);
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::find($request->input('reservation_id'));
        if ($reservation) {
            $reservation->update([
                'reservation_status' => 'deleted',
                'updated_at' => now()
            ]);

            Session::flash('success', 'Reservation Successfully deleted. ');
            return redirect()->route('reservation_listing');
        } else {
            Session::flash('error', 'Invalid Reservation. Please try again. ');
            return redirect()->route('reservation_listing');
        }
    }

    // TODO Staff Manage Reservation
    public function update_status(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $validation = null;

        if (!$reservation) {
            Session::flash('error', 'Invalid Reservation. ');
            return redirect()->route('reservation_listing');
        }

        $menu_img = [];

        foreach ($reservation->order as $key => $order) {
            $menu_img[$order->menu->id] = Menus::get_menu_img($order->menu->slug);
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
            'menu_img' => $menu_img,
            'reservation_status' => ['' => 'Please Select Status', 'Pending' => 'Pending', 'Paid' => 'Paid', 'Arrived' => 'Arrived', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Deleted' => 'Deleted']
        ])->withErrors($validation);
    }

    public function reservation_payment(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            Session::flash('error', 'Invalid Reservation');
            return redirect()->route('reservation_listing');
        }

        $menu_img = [];

        foreach ($reservation->order as $key => $order) {
            $menu_img[$order->menu->id] = Menus::get_menu_img($order->menu->slug);
        }

        return view('reservation.view_payment', [
            'reservation' => $reservation,
            'menu_img' => $menu_img
        ]);
    }

    // TODO Customer Reservation

    public function ajax_add_to_cart(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = auth()->user();
            $order = $request->input('menu_id');

            $check_reservation = Reservation::get_latest_pending_reservation_by_customer($user->id);
            if ($check_reservation) {
                // ? update reservation info & order info
                $reservation = Reservation::find($check_reservation->id);
                $menu = Menus::find($order);

                Orders::create([
                    'reservation_id' => $reservation->id,
                    'menu_id' => $menu->id,
                    'order_quantity' => 1,
                    'order_price' => $menu->price,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                // ? create new reservation & order 
                $new_reservation = Reservation::create([
                    'customer_id' => $user->id,
                    'reservation_status' => 'Pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $menu = Menus::find($order);

                Orders::create([
                    'reservation_id' => $new_reservation->id,
                    'menu_id' => $menu->id,
                    'order_quantity' => 1,
                    'order_price' => $menu->price,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return ['status' => 'success'];
        }
    }

    public function ajax_update_cart(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = auth()->user();
            $menu_id = $request->input('menu_id');
            $quantity = $request->input('quantity');

            $reservation = Reservation::get_latest_pending_reservation_by_customer($user->id);
            $orders = Orders::get_order_by_reservation_menu($reservation->id, $menu_id);

            $menu = Menus::find($menu_id);

            $update_order = Orders::find($orders->id);

            if ($quantity > 0) {
                $update_reservation = Reservation::find($reservation->id);
                $update_reservation->update([
                    'reservation_total_amount' => $request->input('total_sum'),
                    'updated_at' => now()
                ]);
                $update_order->update([
                    'order_quantity' => $quantity,
                    'order_price' => $menu->price * $quantity,
                    'updated_at' => now()
                ]);
            } else {
                Orders::query()->where('id', $orders->id)->delete();
            }

            $check_order = Orders::get_all_orders_by_reservation_id($reservation->id);

            if (count($check_order) == 0) {
                Reservation::query('id', $reservation->id)->update([
                    'reservation_status' => 'Cancelled',
                    'updated_at' => now()
                ]);
            }
        }
    }

    public function customer_checkout(Request $request)
    {
        $user = auth()->user();
        $check_cart = Reservation::get_latest_pending_reservation_by_customer($user->id);
        $get_time = Settings::get_setting_by_slug('operation-time');
        // dd($check_cart);
        if (!$check_cart) {
            Session::flash('error', 'No item in cart. Please add some item before checkout.');
            return redirect()->route('cart');
        }

        if ($request->isMethod('post')) {
            $reservation = Reservation::find($check_cart->id);
            $reservation->update([
                'reservation_total_guest' => $request->input('guest_number'),
                'reservation_date' => $request->input('selected_date'),
                'reservation_time' => $request->input('selected_time'),
                'reservation_remarks' => $request->input('reservation_remarks')
            ]);
            return redirect()->route('confirmation', ['reservation' => md5($reservation->id . '' . env('APP_ENCRYPT'))]);
        }

        return view('guest.reservation.checkout', [
            'customer' => $user,
            'times' => $get_time,
            'check_cart' => $check_cart,
            'submit' => route('checkout')
        ]);
    }

    public function reservation_confirmation(Request $request)
    {
        $get_reservation_id = $request->get('reservation');
        $validator = null;

        if (!$get_reservation_id) {
            Session::flash('error', 'Please create new reservation before checkout.');
            return redirect()->route('cart');
        }

        $check_reservation = Reservation::get_latest_pending_reservation_by_customer(auth()->user()->id);

        if (!$check_reservation) {
            Session::flash('error', 'Please create new reservation before checkout.');
            return redirect()->route('cart');
        }

        if (md5($check_reservation->id . '' . env('APP_ENCRYPT')) != $get_reservation_id) {
            Session::flash('error', 'This reservation has been completed or expired. Create another reservation.');
            return redirect()->route('cart');
        }

        $reservation = Reservation::find($check_reservation->id);

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'reservation_payment' => 'required|mimes:pdf'
            ]);

            if (!$validator->fails()) {

                $reservation->update([
                    'reservation_status' => 'Paid',
                    'updated_at' => now()
                ]);

                if ($request->file('reservation_payment')) {
                    $file_name = $request->file('reservation_payment')->getClientOriginalName();
                    $file = fopen($request->file('reservation_payment')->getPathname(), 'r');
                    app('firebase.storage')->getBucket()->upload($file, ['name' => 'reservation/' . $reservation->id . '/' . $file_name]);
                    $reservation->update([
                        'reservation_payment_slip' => $file_name,
                        'updated_at' => now()
                    ]);
                }

                Session::flash('success', 'Successfully created your reservation, Please arrive on the selected data & time. Thank you. ');
                return redirect()->route('successful_page');
            }

            $reservation = (object) $reservation;
        }

        return view('guest.reservation.confirmation', [
            'reservation_id' => $get_reservation_id,
            'customer' => auth()->user(),
            'reservation' => $reservation,
            'get_menu_imgs' => Menus::get_all_menu_img()
        ])->withErrors($validator);
    }

    public function reservation_history_detail(Request $request, $id)
    {
        $customer = auth()->user();
        $check_reservation = Reservation::check_reservation_from_customer($id, $customer->id);

        if (!$check_reservation) {
            Session::flash('error', 'Invalid reservation history detail.');
            return redirect()->route('welcome');
        }

        $reservation = Reservation::find($check_reservation->id);

        return view('guest.reservation.reservation_history', [
            'reservation' => $reservation,
            'get_menu_imgs' => Menus::get_all_menu_img(),
            'get_reservation_media' => Reservation::get_reservation_media($id)
        ]);
    }
}
