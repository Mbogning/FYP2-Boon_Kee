<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function listing(Request $request)
    {
        $settings = Settings::get_records();

        return view('settings.listing', [
            'settings' => $settings
        ]);
    }

    public function add(Request $request)
    {
        $setting = null;
        $validation = null;

        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'setting_name' => 'required',
                'setting_value' => 'required'
            ]);
            if (!$validation->fails()) {
                $setting = Settings::create([
                    'setting_name' => $request->input('setting_name'),
                    'setting_value' => $request->input('setting_value'),
                    'setting_status' => 'Active'
                ]);

                Session::flash('success', 'Successfully created new setting');
                return redirect()->route('setting_listing');
            }
        }

        return view('settings.form', [
            'title' => 'Add',
            'submit' => route('setting_add'),
            'setting' => $setting
        ])->withErrors($validation);
    }

    public function edit(Request $request, $id)
    {
        $setting = Settings::find($id);
        $validation = null;

        if (!$setting) {
            Session::flash('error', 'Invalid Setting');
            return redirect()->route('setting_listing');
        }

        if ($request->isMethod('post')) {
            $validation = Validator::make($request->all(), [
                'setting_name' => 'required',
                'setting_value' => 'required'
            ]);
            if (!$validation->fails()) {
                $setting->update([
                    'setting_name' => $request->input('setting_name'),
                    'setting_value' => $request->input('setting_value'),
                    'setting_status' => 'Active'
                ]);

                Session::flash('success', 'Successfully updated setting');
                return redirect()->route('setting_listing');
            }
        }

        return view('settings.form', [
            'title' => 'Edit',
            'submit' => route('setting_edit', $id),
            'setting' => $setting
        ]);
    }
}
