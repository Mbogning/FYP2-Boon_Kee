<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function listing(Request $request)
    {
        return view('reservation.listing');
    }

    public function add(Request $request)
    {
        return view('reservation.form', [
            'title' => 'Add',
            'submit' => route('reservation_add')
        ]);
    }

    public function edit(Request $request, $id)
    {
        return view('reservation.form', [
            'title' => 'Edit',
            'submit' => route('reservation_edit', $id)
        ]);
    }

    public function delete(Request $request)
    { }
}
