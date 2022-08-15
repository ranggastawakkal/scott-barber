<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $income_total = Transaction::where('type','income')->sum('total');
        $expense_total = Transaction::where('type','expense')->sum('total');
        $transactions = Transaction::orderBy('created_at','desc')->get();
        $formatted_income_total = number_format($income_total,0,',','.');
        $formatted_expense_total = number_format($expense_total,0,',','.');
        $items = Item::all();
        $packages = Package::all();
        return view('app.pages.journal', compact('transactions', 'items', 'packages', 'formatted_income_total', 'formatted_expense_total'));
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
}
