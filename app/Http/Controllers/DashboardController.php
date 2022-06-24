<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $today = Carbon::now()->toDateTimeString();

        if ($user->isAdmin()) {
            return view('app.admin.dashboard', compact('today'));
        }
        if ($user->isEmployee()) {
            return view('app.employee.dashboard');
        }
    }
}
