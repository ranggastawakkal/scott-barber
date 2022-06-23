<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        // $rules = [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ];

        // $messages = [
        //     'email.required' => 'Email wajib diisi',
        //     'email.email' => 'Email tidak valid',
        //     'password.required' => 'Password wajib diisi',
        // ];

        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput($request->all);
        // }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('app.admin.dashboard');
        }
        if ($user->isEmployee()) {
            return view('app.employee.dashboard');
        }
    }
}
