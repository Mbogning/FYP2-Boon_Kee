<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\MenusType;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Gumlet\ImageResize;

class MenuController extends Controller
{
    public function listing(Request $request)
    {
        return view('menus.listing', [
            'menus' => Menus::get_all(),
            'imgs' => Menus::get_all_menu_img()
        ]);
    }

    public function add(Request $request)
    {
        $validate = null;
        $menu = null;

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'status' => 'required',
                'description' => 'required',
                'type' => 'required'
            ]);

            if (!$validate->fails()) {
                $menu = Menus::create([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'status' => $request->input('status'),
                    'description' => $request->input('description'),
                    'type' => $request->input('type'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                if ($request->file('menu_img')) {
                    $image = new ImageResize($request->file('menu_img'));
                    $image->resize(920, 610, $allow_enlarge = True);


                    $file_name = $request->file('menu_img')->getClientOriginalName();
                    app('firebase.storage')->getBucket()->upload($image, ['name' => 'menus/' . $menu->slug . '/' . $file_name]);
                    $menu->update([
                        'img_name' => $file_name,
                        'updated_at' => now()
                    ]);
                }

                Session::flash('success', 'Successfully created a new menu.');
                return redirect()->route('menu_listing');
            }
        }
        return view('menus.form', [
            'title' => 'Add',
            'submit' => route('menu_add'),
            'menu_type' => MenusType::get_menu_type(),
            'menu' => $menu,
            'status' => ['' => 'Please Select Status', 'active' => 'Active', 'deactive' => 'Deactive']
        ])->withErrors($validate);
    }

    public function edit(Request $request, $id)
    {
        $validate = null;
        $menu = Menus::find($id);

        if (!$menu) {
            Session::flash('error', 'Invalid menu. Please try again.');
            return redirect()->route('menu_listing');
        }

        $menu_img = Menus::get_menu_img($menu->slug);

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'status' => 'required',
                'description' => 'required',
                'type' => 'required'
            ]);

            if (!$validate->fails()) {
                $menu->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'status' => $request->input('status'),
                    'description' => $request->input('description'),
                    'type' => $request->input('type'),
                    'updated_at' => now()
                ]);

                if ($request->file('menu_img')) {
                    if ($menu->img_name) {
                        app('firebase.storage')->getBucket()->object('menus/' . $menu->slug . '/' . $menu->img_name)->delete();
                    }
                    $file_name = $request->file('menu_img')->getClientOriginalName();

                    $image = new ImageResize($request->file('menu_img'));
                    $image->resize(920, 610, $allow_enlarge = True);


                    app('firebase.storage')->getBucket()->upload($image, ['name' => 'menus/' . $menu->slug . '/' . $file_name]);
                    $menu->update([
                        'img_name' => $file_name,
                        'updated_at' => now()
                    ]);
                }

                Session::flash('success', 'Successfully updated menu');
                return redirect()->route('menu_listing');
            }
        }

        return view('menus.form', [
            'title' => 'Edit',
            'submit' => route('menu_edit', $id),
            'menu_type' => MenusType::get_menu_type(),
            'menu' => $menu,
            'menu_img' => $menu_img,
            'status' => ['' => 'Please Select Status', 'active' => 'Active', 'deactive' => 'Deactive']
        ])->withErrors($validate);
    }

    public function delete(Request $request)
    {
        $menu = Menus::find($request->input('menu_id'));
        if ($menu) {
            $menu->update([
                'status' => 'deleted',
                'updated_at' => now()
            ]);

            Session::flash('success', 'Menu Successfully deleted. ');
            return redirect()->route('menu_listing');
        } else {
            Session::flash('error', 'Invalid Menu. Please try again. ');
            return redirect()->route('menu_listing');
        }
    }

    // TODO User Side 
    public function view_menus()
    {
        $menus = Menus::get_active_menu();
        $menu_type = MenusType::get_menu_types();
        $cart = null;
        if (auth()->user()) {
            $cart = Reservation::get_menu_in_cart();
        }

        return view('guest.menu.list', [
            'menus' => $menus,
            'menu_type' => $menu_type,
            'imgs' => Menus::get_all_menu_img(),
            'cart' => $cart
        ]);
    }

    public function view_menu_info($slug)
    {
        $menu = Menus::get_by_slug($slug);
        $cart = null;

        if (!$menu) {
            Session::flash('error', 'No Item Found. The item has been removed or deactive. ');
            return redirect()->route('view_menus');
        }

        if (auth()->user()) {
            $cart = Reservation::get_menu_in_cart();
        }

        return view('guest.menu.info', [
            'menu' => $menu,
            'more_menu' => Menus::get_all_except($slug),
            'menu_img' => Menus::get_menu_img($slug),
            'imgs' => Menus::get_all_menu_img(),
            'cart' => $cart
        ]);
    }

    // TODO AJAX Call
    public function ajax_get_menu(Request $request)
    {
        $arr = [];
        if ($request->isMethod('post')) {
            $name = $request->input('menu_name');
            $menu = Menus::get_menu_by_name($name);
            if ($menu) {
                foreach ($menu as $key => $value) {
                    $arr[$key] = ['id' => $value->id, 'label' => $value->name];
                }

                return ['status' => true, 'result' => $arr];
            } else {
                return ['status' => false];
            }
        }
    }

    public function ajax_get_menu_details(Request $request)
    {
        $menu = "";
        if ($request->isMethod('post')) {
            $menu_id = $request->input('menu_id');
            $menu = Menus::find($menu_id);
            if ($menu) {
                return $menu;
            }
        }
    }
}
