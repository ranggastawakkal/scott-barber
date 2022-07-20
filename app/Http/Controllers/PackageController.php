<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('app.pages.package', compact('packages'));
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
            'name' => 'required|unique:packages,name',
            'price' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Nama paket jasa wajib diisi!',
            'name.unique' => 'Nama paket jasa sudah terdaftar!',
            'price.required' => 'Harga wajib diisi!',
            'price.numeric' => 'Harga wajib berupa angka!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $package = Package::create($request->all());

        if ($package) {
            Alert::success('Berhasil', 'Paket jasa baru berhasil ditambahkan');
            return back();
        }

        Alert::error('Gagal', 'Paket jasa baru gagal ditambahkan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:packages,name,' . $id,
            'price' => 'required|numeric'
        ];

        $messages = [
            'name.required' => 'Nama paket jasa wajib diisi!',
            'name.unique' => 'Nama paket jasa sudah terdaftar!',
            'price.required' => 'Harga wajib diisi!',
            'price.numeric' => 'Harga wajib berupa angka!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $package = Package::find($id)->update($request->all());

        if ($package) {
            Alert::success('Berhasil', 'Paket jasa berhasil diubah');
            return back();
        }

        Alert::error('Gagal', 'Paket jasa gagal diubah');
        return back();
    }

    /**
     * Remove the specified resource from s
     * torage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id)->delete();

        if ($package) {
            Alert::success('Berhasil', 'Paket jasa berhasil dihapus');
            return back();
        }

        Alert::error('Gagal', 'Paket jasa gagal dihapus');
        return back();
    }
}
