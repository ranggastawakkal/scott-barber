<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'employee',
                'email' => 'employee@mail.com',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ],
            [
                'name' => 'employee 2',
                'email' => 'employee2@mail.com',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ],
            [
                'name' => 'employee 3',
                'email' => 'employee3@mail.com',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ],
            [
                'name' => 'employee 4',
                'email' => 'employee4@mail.com',
                'password' => Hash::make('password'),
                'role' => 'employee',
            ]
        ];

        User::insert($users);
    }
}
