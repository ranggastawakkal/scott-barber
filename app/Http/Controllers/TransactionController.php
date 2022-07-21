<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
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
        $transactions = Transaction::whereDate('created_at', date('Y-m-d'))->orderBy('created_at','desc')->get();
        $packages = Package::all();
        $items = Item::all();

        return view('app.pages.daily-transactions', compact('transactions', 'packages','items'));
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
        $rules = [
            'packageIncome' => 'required|exists:packages,id',
            'quantityIncome' => 'required|min:1',
            'subtotalIncome' => 'required'
        ];

        $messages = [
            'packageIncome.required' => 'Wajib memilih paket jasa!',
            'packageIncome.exists' => 'Paket jasa tidak terdaftar!',
            'quantityIncome.required' => 'Jumlah wajib diisi!',
            'quantityIncome.min' => 'Jumlah minimal 1!',
            'subtotalIncome.required' => 'Subtotal wajib diisi!'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $user_id = auth()->user()->id;
        
        $latest_trx_code = Transaction::select('transaction_code')->latest()->first();
        $latest_trx_code_number = (int)substr($latest_trx_code, strpos($latest_trx_code, "-") + 1);
        $next_trx_code_number = $latest_trx_code_number + 1;
        $next_trx_code = 'TRX-' . str_pad($next_trx_code_number, 5, '0', STR_PAD_LEFT);

        foreach($request->noIncome as $key => $no){
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'transaction_code' => $next_trx_code,
                'type'=>'income',
                'package_id'=> $request->packageIncome[$key],
                'quantity'=>$request->quantityIncome[$key],
                'total'=>$request->subtotalIncome[$key]
            ]);
        }
        if ($transaction) {
            Alert::success('Berhasil', 'Transaksi '.$next_trx_code.' berhasil ditambahkan');
            return back();
        }

        Alert::error('Gagal', 'Transaksi gagal ditambahkan');
        return back();
    }

    public function storeExpense(Request $request)
    {
        $rules = [
            'itemExpense' => 'required|exists:items,id',
            'quantityExpense' => 'required|min:1',
            'subtotalExpense' => 'required'
        ];

        $messages = [
            'itemExpense.required' => 'Wajib memilih paket jasa!',
            'itemExpense.exists' => 'Paket jasa tidak terdaftar!',
            'quantityExpense.required' => 'Jumlah wajib diisi!',
            'quantityExpense.min' => 'Jumlah minimal 1!',
            'subtotalExpense.required' => 'Subtotal wajib diisi!'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $user_id = auth()->user()->id;
        
        $latest_trx_code = Transaction::select('transaction_code')->latest()->first();
        $latest_trx_code_number = (int)substr($latest_trx_code, strpos($latest_trx_code, "-") + 1);
        $next_trx_code_number = $latest_trx_code_number + 1;
        $next_trx_code = 'TRX-' . str_pad($next_trx_code_number, 5, '0', STR_PAD_LEFT);

        foreach($request->noExpense as $key => $no){
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'transaction_code' => $next_trx_code,
                'type'=>'expense',
                'item_id'=> $request->itemExpense[$key],
                'quantity'=>$request->quantityExpense[$key],
                'total'=>$request->subtotalExpense[$key]
            ]);

            $item = Item::where('id',$request->itemExpense[$key])->first();
            $stock = $item->stock + $request->quantityExpense[$key];
            $item->update([
                'stock' => $stock
            ]);
        }
        if ($transaction) {
            Alert::success('Berhasil', 'Transaksi '.$next_trx_code.' berhasil ditambahkan');
            return back();
        }

        Alert::error('Gagal', 'Transaksi gagal ditambahkan');
        return back();
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
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $transaction = Transaction::find($id);

        if($transaction->type == 'income'){
            $type = "pemasukan";

            $rules = [
                'package_id' => 'required|exists:packages,id',
                'quantity' => 'required|min:1',
                'total' => 'required'
            ];
    
            $messages = [
                'package_id.required' => 'Wajib memilih paket jasa!',
                'package_id.exists' => 'Paket jasa tidak terdaftar!',
                'quantity.required' => 'Jumlah wajib diisi!',
                'quantity.min' => 'Jumlah minimal 1!',
                'total.required' => 'Subtotal wajib diisi!'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->all);
            }

            $update = $transaction->update($request->all());
            
            if($update){
                Alert::success('Berhasil', 'Data pemasukan berhasil diubah');
                return back();
            }
        } else{
            $type = "pengeluaran";

            $rules = [
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required|min:1',
                'total' => 'required'
            ];
    
            $messages = [
                'item_id.required' => 'Wajib memilih paket jasa!',
                'item_id.exists' => 'Paket jasa tidak terdaftar!',
                'quantity.required' => 'Jumlah wajib diisi!',
                'quantity.min' => 'Jumlah minimal 1!',
                'total.required' => 'Subtotal wajib diisi!'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->all);
            }

            $update = $transaction->update($request->all());

            $item = Item::where('id',$request->item_id)->first();
            $stock = $item->stock - $transaction->quantity + $request->quantity;
            $item->update([
                'stock' => $stock
            ]);
            
            if($update){
                Alert::success('Berhasil', 'Data pengeluaran berhasil diubah');
                return back();
            }
        }

        Alert::error('Gagal', 'Data '.$type.' gagal diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction, $id)
    {
        $transaction = Transaction::find($id)->delete();

        if ($transaction) {
            Alert::success('Berhasil', 'Data transaksi berhasil dihapus');
            return back();
        }

        Alert::error('Gagal', 'Data transaksi gagal dihapus');
        return back();
    }

    public function getPackagePrice(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        return response()->json($package->getFormattedPriceAttribute());
    }
}
