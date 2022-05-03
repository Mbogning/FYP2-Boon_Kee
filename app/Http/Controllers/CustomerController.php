<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Orders;
use App\Models\Reservation;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except(['about_us']);
    }

    public function about_us()
    {
        return view('guest.about-us');
    }

    public function cart(Request $request)
    {
        $menu = [];
        $user = auth()->user();
        $reservation = Reservation::get_latest_pending_reservation_by_customer($user->id);
        $cart = null;

        if ($reservation) {
            $cart = Orders::get_all_orders_by_reservation_id($reservation->id);

            foreach ($cart as $key => $value) {
                $menu[$value->menu_id] = Menus::get_menu_by_id_with_img($value->menu_id);
            }
        }

        return view('guest.cart', [
            'cart' => $cart,
            'menu' => $menu
        ]);
    }
}
