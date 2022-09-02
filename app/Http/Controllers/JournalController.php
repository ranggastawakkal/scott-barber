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
        $expense_subtotal = Transaction::where('type','expense')->sum('total');
        $packages = Transaction::select('package_id')->where('package_id','!=','null')->groupBy('package_id')->get();
        // dd($packages);
        $income_subtotal = Transaction::where('type','income')->selectRaw('SUM(total) as total')->groupBy('package_id')->get();

        // $incomes = array_merge($packages,$income_subtotal);

        // print_r($income_subtotal);

        $biaya_listrik = 200000;
        $biaya_air = 60000;
        $biaya_gaji = 5000000;
        
        $expense_total = $expense_subtotal + $biaya_listrik + $biaya_air + $biaya_gaji;
        $cash_total = $income_total - $expense_total;
        $formatted_income_total = number_format($income_total,0,',','.');
        $formatted_expense_subtotal = number_format($expense_subtotal,0,',','.');
        $formatted_expense_total = number_format($expense_total,0,',','.');
        $formatted_cash_total = number_format($cash_total,0,',','.');
        $formatted_biaya_listrik = number_format($biaya_listrik,0,',','.');
        $formatted_biaya_air = number_format($biaya_air,0,',','.');
        $formatted_biaya_gaji = number_format($biaya_gaji,0,',','.');

        $from_date = Transaction::select('created_at')->orderBy('created_at','asc')->first();
        $to_date = Transaction::select('created_at')->orderBy('created_at','desc')->first();

        return view('app.pages.income-statement', compact('packages','income_subtotal','formatted_income_total','formatted_expense_subtotal','formatted_expense_total','formatted_cash_total', 'formatted_biaya_listrik','formatted_biaya_air','formatted_biaya_gaji', 'from_date','to_date'));
    }

    public function getTotalValue($minDate,$maxDate)
    {
        $income_total = Transaction::where('type', 'income')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $expense_total = Transaction::where('type', 'expense')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $formatted_income_total = number_format($income_total,0,',','.');
        $formatted_expense_total = number_format($expense_total,0,',','.');
        return response()->json([
            'formatted_income_total' => $formatted_income_total,
            'formatted_expense_total' => $formatted_expense_total
        ]);
    }

    public function getIncomeStatementValue($minDate,$maxDate)
    {
        $income_total = Transaction::where('type', 'income')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $expense_subtotal = Transaction::where('type', 'expense')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->sum('total');
        $packages = DB::table('transactions')->leftJoin('packages','transactions.package_id','=','packages.id')->select('packages.name','transactions.package_id')->where('package_id','!=','null')->whereBetween('transactions.created_at', [$minDate, $maxDate . ' 23:59:59'])->groupBy('package_id')->get();
        // $packages = Transaction::select('package_id')->where('package_id','!=','null')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->groupBy('package_id')->get();
        $income_subtotal = Transaction::where('type','income')->selectRaw('SUM(total) as total')->whereBetween('created_at', [$minDate, $maxDate . ' 23:59:59'])->groupBy('package_id')->get();
        
        $biaya_listrik = 200000;
        $biaya_air = 60000;
        $biaya_gaji = 5000000;
        
        $expense_total = $expense_subtotal + $biaya_listrik + $biaya_air + $biaya_gaji;
        $cash_total = $income_total - $expense_total;
        $formatted_income_total = 'Rp. ' . number_format($income_total,0,',','.');
        $formatted_expense_subtotal = 'Rp. ' . number_format($expense_subtotal,0,',','.');
        $formatted_expense_total = 'Rp. ' . number_format($expense_total,0,',','.');
        $formatted_cash_total = 'Rp. ' . number_format($cash_total,0,',','.');
        $formatted_biaya_listrik = number_format($biaya_listrik,0,',','.');
        $formatted_biaya_air = number_format($biaya_air,0,',','.');
        $formatted_biaya_gaji = number_format($biaya_gaji,0,',','.');
        
        $from_date = Carbon::parse($minDate)->format('d M Y');
        $to_date = Carbon::parse($maxDate)->format('d M Y');

        return response()->json([
            'formatted_income_total' => $formatted_income_total,
            'formatted_expense_subtotal' => $formatted_expense_subtotal,
            'formatted_expense_total' => $formatted_expense_total,
            'formatted_cash_total' => $formatted_cash_total,
            'formatted_biaya_listrik' => $formatted_biaya_listrik,
            'formatted_biaya_air' => $formatted_biaya_air,
            'formatted_biaya_gaji' => $formatted_biaya_gaji,
            'packages' => $packages,
            'income_subtotal' => $income_subtotal,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }
}
