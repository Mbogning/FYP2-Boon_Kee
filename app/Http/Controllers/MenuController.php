<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\MenusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function listing(Request $request)
    {
        return view('menus.listing', [
            'menus' => Menus::get_all()
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

                Session::flash('success', 'Successfully updated menu');
                return redirect()->route('menu_listing');
            }
        }

        return view('menus.form', [
            'title' => 'Edit',
            'submit' => route('menu_edit', $id),
            'menu_type' => MenusType::get_menu_type(),
            'menu' => $menu,
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
}
