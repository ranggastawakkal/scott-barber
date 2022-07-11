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
                'user_id' => 2,
                'transaction_code' => 'TRX-00001',
                'type' => 'income',
                'package_id' => 1,
                'item_id' => null,
                'quantity' => 1,
                'total' => 25000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-00002',
                'type' => 'income',
                'package_id' => 2,
                'item_id' => null,
                'quantity' => 1,
                'total' => 20000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'transaction_code' => 'TRX-00003',
                'type' => 'expense',
                'package_id' => null,
                'item_id' => 1,
                'quantity' => 1,
                'total' => 5000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'transaction_code' => 'TRX-00003',
                'type' => 'expense',
                'package_id' => null,
                'item_id' => 2,
                'quantity' => 1,
                'total' => 10000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Transaction::insert($transactions);
    }
}
