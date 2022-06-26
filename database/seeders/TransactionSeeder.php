<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = [
            [
                'transaction_code' => 'TRX-00001',
                'type' => 'income',
                'amount' => 25000,
                'pay' => 50000,
                'charge' => 25000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_code' => 'TRX-00002',
                'type' => 'income',
                'amount' => 20000,
                'pay' => 20000,
                'charge' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_code' => 'TRX-00003',
                'type' => 'income',
                'amount' => 40000,
                'pay' => 50000,
                'charge' => 10000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_code' => 'TRX-00004',
                'type' => 'expense',
                'amount' => 45000,
                'pay' => 45000,
                'charge' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Transaction::insert($transactions);
    }
}
