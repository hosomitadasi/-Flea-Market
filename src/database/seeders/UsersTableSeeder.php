<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $param = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'zip_code' => '123-4567',
            'address' => 'Tokyo, Japan',
            'building' => 'Test Building',
        ];
        DB::table('users')->insert($param);
    }
}
