<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $incomes = [
            [
                'transaction_code' => 'TRX-0001',
                'package_id' => 1,
                'quantity' => 1,
                'amount' => 25000,
                'pay' => 50000,
                'charge' => 25000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_code' => 'TRX-0002',
                'package_id' => 1,
                'quantity' => 1,
                'amount' => 25000,
                'pay' => 100000,
                'charge' => 75000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_code' => 'TRX-0003',
                'package_id' => 1,
                'quantity' => 2,
                'amount' => 50000,
                'pay' => 50000,
                'charge' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
    }
}
