<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::where('role', 'employee')->get();

        return view('app.pages.employee', compact('employees'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'name.required' => 'Nama karyawan wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password wajib diisi!',
            'password.string' => 'Password harus berupa string!',
            'password.min' => 'Panjang password minimal 6 karakter!',
            'password.confirmed' => 'Password dan konfirmasi password harus sama!',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all);
        }

        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employee',
            'password' => Hash::make($request->password)
        ]);

        if ($employee) {
            Alert::success('Berhasil', 'Karyawan baru berhasil ditambahkan');
            return back();
        }

        Alert::error('Gagal', 'Karyawan baru gagal ditambahkan');
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ];

        $messages = [
            'name.required' => 'Nama karyawan wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $employee = User::find($id);
        if (($request->password == null) && ($request->password_confirmation == null)) {
            $update = $employee->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        } else {
            $rules = [
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ];
    
            $messages = [
                'password.required' => 'Password wajib diisi!',
                'password.string' => 'Password harus berupa string!',
                'password.min' => 'Panjang password minimal 6 karakter!',
                'password.confirmed' => 'Password dan konfirmasi password harus sama!',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi!',
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages);
    
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $update = $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }

        if ($update) {
            Alert::success('Berhasil', 'Data karyawan berhasil diubah');
            return back();
        }

        Alert::error('Gagal', 'Data karyawan gagal diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = User::find($id)->delete();

        if ($employee) {
            Alert::success('Berhasil', 'Data karyawan berhasil dihapus');
            return back();
        }

        Alert::error('Gagal', 'Data karyawan gagal dihapus');
        return back();
    }
}
