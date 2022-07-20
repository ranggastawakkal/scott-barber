<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Models\Package;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        $items = Item::all();
        $packages = Package::all();
        return view('app.pages.journal', compact('transactions','items','packages'));
    }
}
