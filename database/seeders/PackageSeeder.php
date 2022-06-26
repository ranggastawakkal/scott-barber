<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'name' => 'Haircut for Mens',
                'price' => '25000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Haircut for Kids',
                'price' => '20000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shaving',
                'price' => '10000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Full Head Shave',
                'price' => '30000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hair Wash',
                'price' => '5000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Basic Color Black',
                'price' => '40000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Package::insert($packages);
    }
}
