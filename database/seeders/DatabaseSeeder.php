<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\IncomeSeeder;
use Database\Seeders\ExpenseSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\TransactionSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PackageSeeder::class,
            ItemSeeder::class,
            TransactionSeeder::class,
            // ExpenseSeeder::class,
            // IncomeSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
