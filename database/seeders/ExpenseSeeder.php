<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenses = [
            [
                'transaction_id' => 4,
                'item_id' => 1,
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_id' => 4,
                'item_id' => 10,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Expense::insert($expenses);
    }
}
