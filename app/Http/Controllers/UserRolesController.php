<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolesController extends Controller
{
    public function listing(Request $request)
    {
        $roles = Role::query()->paginate(15);
        return view('role_permission.roles_list', [
            'roles' => $roles
        ]);
    }

    public function add(Request $request)
    {
        $validate = null;
        $role = null;
        $permissions = Permission::all();

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if (!$validate->fails()) {
                $role = Role::create([
                    'name' => $request->input('name')
                ]);

                $role->syncPermissions($request->input('permissions'));

                Session::flash('success', 'Successfully created new role.');
                return redirect()->route('user_roles_listing');
            }
        }

        return view('role_permission.roles_form', [
            'title' => 'Add',
            'submit' => route('user_roles_add'),
            'role' => $role,
            'permissions' => $permissions
        ])->withErrors($validate);
    }

    public function edit(Request $request, $id)
    { 
        $validate = null;
        $role = Role::findById($id);
        $permissions = Permission::all();

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if (!$validate->fails()) {
                
                $role->update([
                    'name' => $request->input('name')
                ]);

                $role->syncPermissions($request->input('permissions'));

                Session::flash('success', 'Successfully update role.');
                return redirect()->route('user_roles_listing');
            }
        }

        return view('role_permission.roles_form', [
            'title' => 'Edit',
            'submit' => route('user_roles_edit', $id),
            'role' => $role,
            'permissions' => $permissions
        ])->withErrors($validate);
    }

    public function delete(Request $request)
    { }
}
