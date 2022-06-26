<?php

namespace Database\Seeders;

use App\Models\Income;
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
                'transaction_id' => 1,
                'package_id' => 1,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_id' => 2,
                'package_id' => 2,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_id' => 3,
                'package_id' => 3,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'transaction_id' => 3,
                'package_id' => 4,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Income::insert($incomes);
    }
}
