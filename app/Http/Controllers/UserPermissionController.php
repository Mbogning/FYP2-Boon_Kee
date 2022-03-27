<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function listing(Request $request)
    {
        $permissions = Permission::query()->paginate(15);
        return view('role_permission.permission_list', [
            'permissions' => $permissions
        ]);
    }

    public function add(Request $request)
    {
        $validate = null;
        $permission = null;

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            if (!$validate->fails()) {
                Permission::create([
                    'name' => $request->input('name')
                ]);
            }

            Session::flash('success', 'Successfully added new permission.');
            return redirect()->route('user_permission_listing');
        }

        return view('role_permission.permission_form', [
            'title' => 'Add',
            'permission' => $permission,
            'submit' => route('user_permission_add')
        ])->withErrors($validate);
    }

    public function edit(Request $request, $id)
    { }

    public function delete(Request $request)
    { }
}
