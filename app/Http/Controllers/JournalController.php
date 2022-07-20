<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('app.admin.journal', compact('transactions'));
    }
}
