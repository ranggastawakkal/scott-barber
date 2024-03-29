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
                'created_at' => "2022-08-01 19:12:06",
                'updated_at' => "2022-08-01 19:12:06"
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-00002',
                'type' => 'income',
                'package_id' => 2,
                'item_id' => null,
                'quantity' => 1,
                'total' => 20000,
                'created_at' => "2022-08-01 19:12:06",
                'updated_at' => "2022-08-01 19:12:06"
            ],
            [
                'user_id' => 4,
                'transaction_code' => 'TRX-00003',
                'type' => 'expense',
                'package_id' => null,
                'item_id' => 1,
                'quantity' => 1,
                'total' => 5000,
                'created_at' => "2022-08-02 19:12:06",
                'updated_at' => "2022-08-02 19:12:06"
            ],
            [
                'user_id' => 4,
                'transaction_code' => 'TRX-00003',
                'type' => 'expense',
                'package_id' => null,
                'item_id' => 2,
                'quantity' => 1,
                'total' => 10000,
                'created_at' => "2022-08-02 19:12:06",
                'updated_at' => "2022-08-02 19:12:06"
            ],
            [
                'user_id' => 5,
                'transaction_code' => 'TRX-00004',
                'type' => 'income',
                'package_id' => 6,
                'item_id' => null,
                'quantity' => 2,
                'total' => 80000,
                'created_at' => "2022-08-03 19:12:06",
                'updated_at' => "2022-08-03 19:12:06"
            ],
            [
                'user_id' => 5,
                'transaction_code' => 'TRX-00005',
                'type' => 'income',
                'package_id' => 5,
                'item_id' => null,
                'quantity' => 3,
                'total' => 15000,
                'created_at' => "2022-08-04 19:12:06",
                'updated_at' => "2022-08-04 19:12:06"
            ],
            [
                'user_id' => 5,
                'transaction_code' => 'TRX-00005',
                'type' => 'income',
                'package_id' => 2,
                'item_id' => null,
                'quantity' => 1,
                'total' => 20000,
                'created_at' => "2022-08-05 19:12:06",
                'updated_at' => "2022-08-05 19:12:06"
            ],
        ];

        Transaction::insert($transactions);
    }
}
