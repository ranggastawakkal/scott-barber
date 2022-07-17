<?php

namespace App\Http\Controllers;

use Alert;
use Carbon\Carbon;
use App\Models\Income;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $income_per_day = Transaction::select(DB::raw('SUM(total) AS total'))->where('type', 'income')->whereMonth('created_at', date('m'))->groupBy(DB::raw('DAY(created_at)'))->orderBy(DB::raw('DAY(created_at)'), 'asc')->get();
        $date_per_month = Transaction::select(DB::raw('DAY(created_at) AS date'))->where('type', 'income')->whereMonth('created_at', date('m'))->groupBy('date')->orderBy('date', 'asc')->get();
        $packages = Transaction::select('package_id', DB::raw('SUM(quantity) AS qty'))->where('type', 'income')->groupBy('package_id')->orderBy('qty', 'desc')->get();
        $package_best_selling = Transaction::select('package_id', DB::raw('SUM(quantity) AS qty'))->where('type', 'income')->groupBy('package_id')->orderBy('qty', 'desc')->get();

        $user = Auth::user();

        $today = Carbon::now()->toDateTimeString();

        if ($user->isAdmin()) {
            $income = Transaction::where('type', 'income')->whereDate('created_at', date('Y-m-d'))->sum('total');
            $expense = Transaction::where('type', 'expense')->whereDate('created_at', date('Y-m-d'))->sum('total');
            $income_per_month = Transaction::where('type', 'income')->whereMonth('created_at', date('m'))->sum('total');
            $expense_per_month = Transaction::where('type', 'expense')->whereMonth('created_at', date('m'))->sum('total');

            if (!$income) {
                $income = 0;
            }
            if (!$expense) {
                $expense = 0;
            }
            if (!$income_per_month) {
                $income_per_month = 0;
            }
            if (!$expense_per_month) {
                $expense_per_month = 0;
            }

            $cash_per_month = $income_per_month - $expense_per_month;

            if ($cash_per_month < 0) {
                $color = 'text-danger';
            } elseif ($cash_per_month > 0) {
                $color = 'text-success';
            } else {
                $color = 'text-gray-800';
            }

            return view('app.admin.dashboard', compact('income', 'expense', 'cash_per_month', 'color', 'date_per_month', 'income_per_day', 'packages', 'package_best_selling'));
        }
        if ($user->isEmployee()) {
            return view('app.employee.dashboard');
        }
    }
}
