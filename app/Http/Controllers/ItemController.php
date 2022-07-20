<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('app.pages.item', compact('items'));
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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:items,name',
            'stock' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Nama barang wajib diisi!',
            'name.unique' => 'Nama barang sudah terdaftar!',
            'stock.required' => 'Stok barang wajib diisi!',
            'stock.numeric' => 'Stok barang wajib berupa angka!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $item = Item::create($request->all());

        if ($item) {
            Alert::success('Berhasil', 'Barang baru berhasil ditambahkan');
            return back();
        }

        Alert::error('Gagal', 'Barang baru gagal ditambahkan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:items,name,' . $id,
            'stock' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Nama barang wajib diisi!',
            'name.unique' => 'Nama barang sudah terdaftar!',
            'stock.required' => 'Stok barang wajib diisi!',
            'stock.numeric' => 'Stok barang wajib berupa angka!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $item = Item::find($id)->update($request->all());

        if ($item) {
            Alert::success('Berhasil', 'Barang berhasil diubah');
            return back();
        }

        Alert::error('Gagal', 'Barang gagal diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, $id)
    {
        $item = Item::find($id)->delete();

        if ($item) {
            Alert::success('Berhasil', 'Barang berhasil dihapus');
            return back();
        }

        Alert::error('Gagal', 'Barang gagal dihapus');
        return back();
    }
}
