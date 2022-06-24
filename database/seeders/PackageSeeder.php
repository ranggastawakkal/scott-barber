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
                'code' => 'PKG001',
                'name' => 'Haircut for Mens',
                'price' => '25000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PKG002',
                'name' => 'Haircut for Kids',
                'price' => '20000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PKG003',
                'name' => 'Shaving',
                'price' => '10000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PKG004',
                'name' => 'Full Head Shave',
                'price' => '30000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PKG005',
                'name' => 'Hair Wash',
                'price' => '5000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PKG006',
                'name' => 'Basic Color Black',
                'price' => '40000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Package::insert($packages);
    }
}
