<?php

namespace App\Http\Controllers;

use App\Models\MenusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MenusTypeController extends Controller
{
    public function listing(Request $request)
    {
        return view('menus_type.listing', [
            'menu_types' => MenusType::get_all()
        ]);
    }

    public function add(Request $request)
    {
        $validate = null;
        $type = null;

        if ($request->isMethod('post')) {

            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'status' => 'required'
            ]);

            if (!$validate->fails()) {
                $type = MenusType::create([
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                Session::flash('success', 'Successfully created a new menu type');
                return redirect()->route('menu_type_listing');
            }
        }

        return view('menus_type.form', [
            'title' => 'Add',
            'submit' => route('menu_type_add'),
            'type' => $type,
            'status' => ['' => 'Please Select Status', 'active' => 'Active', 'deactive' => 'Deactive']
        ])->withErrors($validate);
    }

    public function edit(Request $request, $id)
    {
        $validate = null;
        $type = MenusType::find($id);

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'status' => 'required'
            ]);

            if (!$validate->fails()) {
                $type->update([
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                    'updated_at' => now()
                ]);

                Session::flash('success', 'Successfully updated menu type');
                return redirect()->route('menu_type_listing');
            }
        }

        return view('menus_type.form', [
            'title' => 'Edit',
            'submit' => route('menu_type_edit', $id),
            'type' => $type,
            'status' => ['' => 'Please Select Status', 'active' => 'Active', 'deactive' => 'Deactive']
        ])->withErrors($validate);
    }

    public function delete(Request $request)
    { }
}
