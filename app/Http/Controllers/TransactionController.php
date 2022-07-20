<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::whereDate('created_at', date('Y-m-d'))->get();
        $packages = Package::all();

        return view('app.admin.daily-transactions', compact('transactions', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIncome(Request $request)
    {
        dd($request->all());
        $rules = [
            'package' => 'required|exists:packages,id',
            'quantity' => 'required|numeric|min:1',
            'subtotal' => 'required|numeric'
        ];

        $messages = [
            'package.required' => 'Wajib memilih paket jasa!',
            'package.exists' => 'Paket jasa tidak terdaftar!',
            'quantity.required' => 'Jumlah wajib diisi!',
            'quantity.numeric' => 'Jumlah wajib berupa angka!',
            'quantity.min' => 'Jumlah minimal 1!',
            'subtotal.required' => 'Subtotal wajib diisi!',
            'subtotal.numeric' => 'Subtotal wajib berupa angka!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $latest_trx_code_number = Transaction::select('transaction_code')->latest()->first();
        $next_trx_code_number = (int)substr($latest_trx_code_number, strpos($latest_trx_code_number, "-") + 1) + 1;
        $trx_code = 'TRX-' . str_pad($next_trx_code_number, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function getPackagePrice(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        return response()->json($package->getFormattedPriceAttribute());
    }
}
