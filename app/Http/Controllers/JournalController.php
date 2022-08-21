<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function cashFlow()
    {
        $income_total = Transaction::where('type','income')->sum('total');
        $expense_total = Transaction::where('type','expense')->sum('total');
        $cash_total = $income_total - $expense_total;
        $transactions = Transaction::orderBy('created_at','desc')->get();
        $formatted_income_total = number_format($income_total,0,',','.');
        $formatted_expense_total = number_format($expense_total,0,',','.');
        $formatted_cash_total = number_format($cash_total,0,',','.');
        $items = Item::all();
        $packages = Package::all();
        return view('app.pages.cash-flow', compact('transactions', 'items', 'packages', 'formatted_income_total', 'formatted_expense_total', 'formatted_cash_total'));
    }

    public function incomeStatement(){
        $income_total = Transaction::where('type','income')->sum('total');
        $expense_total = Transaction::where('type','expense')->sum('total');
        $cash_total = $income_total - $expense_total;
        $formatted_income_total = number_format($income_total,0,',','.');
        $formatted_expense_total = number_format($expense_total,0,',','.');
        $formatted_cash_total = number_format($cash_total,0,',','.');

        $from_date = Transaction::select('created_at')->orderBy('created_at','asc')->first();
        $to_date = Transaction::select('created_at')->orderBy('created_at','desc')->first();

        return view('app.pages.income-statement', compact('formatted_income_total','formatted_expense_total','formatted_cash_total','from_date','to_date'));
    }

    public function getTotalValue($minDate,$maxDate)
    {
        $income_total = Transaction::where('type', 'income')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $expense_total = Transaction::where('type', 'expense')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $formatted_income_total = 'Rp. ' . number_format($income_total,0,',','.');
        $formatted_expense_total = 'Rp. ' . number_format($expense_total,0,',','.');
        return response()->json([
            'formatted_income_total' => $formatted_income_total,
            'formatted_expense_total' => $formatted_expense_total
        ]);
    }

    public function getIncomeStatementValue($minDate,$maxDate)
    {
        $income_total = Transaction::where('type', 'income')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $expense_total = Transaction::where('type', 'expense')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $cash_total = $income_total - $expense_total;
        $formatted_income_total = 'Rp. ' . number_format($income_total,0,',','.');
        $formatted_expense_total = 'Rp. ' . number_format($expense_total,0,',','.');
        $formatted_cash_total = 'Rp. ' . number_format($cash_total,0,',','.');
        
        $from_date = Carbon::parse($minDate)->format('d M Y');
        $to_date = Carbon::parse($maxDate)->format('d M Y');

        return response()->json([
            'formatted_income_total' => $formatted_income_total,
            'formatted_expense_total' => $formatted_expense_total,
            'formatted_cash_total' => $formatted_cash_total,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }
}
