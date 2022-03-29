<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }

    public function listing(Request $request)
    {
        if ($request->isMethod('post')) {
            switch ($request->input('submit')) {
                case "submit":
                    Session::put('user_search', [
                        'freetext' => $request->input('freetext')
                    ]);
                    break;
                case "reset":
                    Session::forget('user_search');
                    break;
            }
        }
        $search = session('user_search') ?? [];
        $users = User::get_records($search);
        return view('users.listing', [
            'users' => $users,
            'search' => $search
        ]);
    }

    public function add(Request $request)
    {
        $validate = null;
        $user = null;

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'bod' => 'required',
                'gender' => 'required'
            ])->setAttributeNames([
                'name' => 'Full Name',
                'email' => 'Email',
                'phone' => 'Phone Number',
                'bod' => 'Birth of Date',
                'gender' => 'Gender'
            ]);

            if (!$validate->fails()) {

                $user_mobile = $request->input('phone');
                if (substr($user_mobile, 0, 1) == '0') {
                    $profile_mobile = '6' . $user_mobile;
                } elseif (substr($user_mobile, 0, 1) == '1') {
                    $profile_mobile = "60" . $user_mobile;
                } elseif (substr($user_mobile, 0, 3) == '600') {
                    $profile_mobile = "6" . substr($user_mobile, strpos($user_mobile, '600') + 2);
                } else {
                    $profile_mobile = $user_mobile;
                }

                $pass = substr($profile_mobile, -8);

                $user = User::create([
                    'name' => $request->input('name'),
                    'password' => Hash::make($pass),
                    'email' => $request->input('email'),
                    'phone' => $profile_mobile,
                    'bod' => $request->input('bod'),
                    'gender' => $request->input('gender'),
                    'status' => 'active'
                ]);

                $user->syncRoles($request->input('role_id'));

                Session::flash('success', 'Successfully created a new user. ');
                return redirect()->route('user_listing');
            }

            $user = (object) $request->all();
        }

        return view('users.form', [
            'title' => 'Add',
            'user' => $user,
            'submit' => route('user_add'),
            'gender' => ['male' => 'Male', 'female' => 'Female'],
            'roles' => Role::all()
        ])->withErrors($validate);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $validate = null;

        if ($request->isMethod('post')) {
            // dd($request->all());
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'bod' => 'required',
                'gender' => 'required'
            ])->setAttributeNames([
                'name' => 'Full Name',
                'email' => 'Email',
                'phone' => 'Phone Number',
                'bod' => 'Birth of Date',
                'gender' => 'Gender'
            ]);

            if (!$validate->fails()) {

                $user_mobile = $request->input('phone');
                if (substr($user_mobile, 0, 1) == '0') {
                    $profile_mobile = '6' . $user_mobile;
                } elseif (substr($user_mobile, 0, 1) == '1') {
                    $profile_mobile = "60" . $user_mobile;
                } elseif (substr($user_mobile, 0, 3) == '600') {
                    $profile_mobile = "6" . substr($user_mobile, strpos($user_mobile, '600') + 2);
                } else {
                    $profile_mobile = $user_mobile;
                }

                $user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $profile_mobile,
                    'bod' => $request->input('bod'),
                    'gender' => $request->input('gender'),
                    'status' => 'active'
                ]);

                $user->syncRoles($request->input('role_id'));

                Session::flash('success', 'Successfully updated user details. ');
                // return route('user_listing');
                return redirect()->route('user_listing');
            }

            $user = (object) $request->all();
        }

        return view('users.form', [
            'title' => 'Edit',
            'user' => $user,
            'submit' => route('user_edit', $id),
            'gender' => ['male' => 'Male', 'female' => 'Female'],
            'roles' => Role::all()
        ])->withErrors($validate);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if ($user) {
            $user->update([
                'status' => 'deleted',
                'updated_at' => now()
            ]);

            Session::flash('success', 'User Successfully deleted. ');
            return redirect()->route('user_listing');
        } else {
            Session::flash('error', 'Invalid User. Please try again. ');
            return redirect()->route('user_listing');
        }
    }

    public function admin_profile(Request $request)
    {
        $validate = null;

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'bod' => 'required',
                'gender' => 'required'
            ])->setAttributeNames([
                'name' => 'Full name',
                'phone' => 'Phone Number',
                'bod' => 'Birth of Date',
                'gender' => 'Gender'
            ]);

            if (!$validate->fails()) {
                $user_id = auth()->user()->id;
                $user = User::find($user_id);

                $user_mobile = $request->input('phone');
                if (substr($user_mobile, 0, 1) == '0') {
                    $profile_mobile = '6' . $user_mobile;
                } elseif (substr($user_mobile, 0, 1) == '1') {
                    $profile_mobile = "60" . $user_mobile;
                } elseif (substr($user_mobile, 0, 3) == '600') {
                    $profile_mobile = "6" . substr($user_mobile, strpos($user_mobile, '600') + 2);
                } else {
                    $profile_mobile = $user_mobile;
                }

                $user->update([
                    'name' => $request->input('name'),
                    'phone' => $profile_mobile,
                    'bod' => $request->input('bod'),
                    'gender' => $request->input('gender'),
                    'updated_at' => now()
                ]);

                Session::flash('success', 'Successfully updated profile details. ');
                return redirect()->route('user_profile');
            }
        }

        return view('users.profile', [
            'user' => auth()->user(),
            'gender' => ['male' => 'Male', 'female' => 'Female']
        ])->withErrors($validate);
    }

    public function working_schedule(Request $request)
    {
        $selected_date = null;
        $all_schedule = WorkSchedule::query()->where('status', 'active')->get();
        if ($request->isMethod('post')) {
            $selected_date = WorkSchedule::query()->where('status', 'active')->where('work_date', $request->input('date'))->with(['role','user'])->get();
            return ['date' => $request->input('date'), 'result' => $selected_date];
            // return 'returning post result '. $request->input('date');
        }

        return view('work_schedule.list', [
            'all_schedule' => $all_schedule,
            'roles' => ['' => 'Please Select Role', '1' => 'Admin', '3' => 'Chef', '5' => 'Cashier', '4' => 'Waiter']
        ]);
    }

    public function insert_working_schedule(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'user_role_id' => 'required',
            'user_id' => 'required',
            'work_date' => 'required',
            'status' => 'required'
        ]);

        if (!$validate->fails()) {
            WorkSchedule::create([
                'user_role_id' => $request->input('user_role_id'),
                'user_id' => $request->input('user_id'),
                'work_date' => $request->input('work_date'),
                'status' => $request->input('status')
            ]);
            Session::flash('success', 'Successfully inserted a new working schedule');
            return redirect()->route('working_schedule');
        } else {
            Session::flash('error', 'Error while creating new working schedule. Please try again.');
            return redirect()->route('working_schedule');
        }
    }

    public function search_user_role(Request $request)
    {
        if ($request->isMethod('post')) {
            $arr = [];
            $users = User::role($request->input('role'))->get();

            if (count($users) > 0) {
                foreach ($users as $key => $user) {
                    $arr[$user->id] = $user->name;
                }
                return ['status' => 'true', 'data' => $arr];
            } else {
                return ['status' => 'false', 'data' => ''];
            }
        }
    }

    // ? User Side 
    public function user_profile(Request $request)
    {
        $user = auth()->user();
        $validate = null;

        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'bod' => 'required',
                'gender' => 'required',
            ])->setAttributeNames([
                'name' => 'Fullname',
                'phone' => 'Phone Number',
                'bod' => 'Birth of Date',
                'gender' => 'Gender'
            ]);

            if (!$validate->fails()) {
                $find_user = User::find($user->id);
                $find_user->update([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'bod' => $request->input('bod'),
                    'gender' => $request->input('gender')
                ]);

                Session::flash('success', 'Successfully update profile details.');
                return redirect()->route('profile');
            }
        }

        return view('guest.user.profile', [
            'user' => $user,
            'gender' => ['male' => 'Male', 'female' => 'Female']
        ])->withErrors($validate);
    }
}
