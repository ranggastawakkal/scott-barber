<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Gunting',
                'stock' => '5'
            ],
            [
                'name' => 'Sisir',
                'stock' => '5'
            ],
            [
                'name' => 'Kursi',
                'stock' => '5'
            ],
            [
                'name' => 'Clipper',
                'stock' => '5'
            ],
            [
                'name' => 'Clipper Wireless',
                'stock' => '5'
            ],
            [
                'name' => 'Razor',
                'stock' => '5'
            ],
            [
                'name' => 'Apron Pelanggan',
                'stock' => '5'
            ],
            [
                'name' => 'Apron Barberman',
                'stock' => '5'
            ],
            [
                'name' => 'Handuk',
                'stock' => '10'
            ],
            [
                'name' => 'Spray Bottle',
                'stock' => '5'
            ],
        ];

        Item::insert($items);
    }
}
