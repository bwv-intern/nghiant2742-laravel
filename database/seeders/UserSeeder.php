<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('123123'),
        //         'user_flg' => 0,
        //         'date_of_birth' => fake()->date(),
        //         'phone' => '0123456789',
        //         'address' => fake()->address(),
        //     ],
        //     [
        //         'name' => 'User',
        //         'email' => 'user@gmail.com',
        //         'password' => Hash::make('123123'),
        //         'user_flg' => 1,
        //         'date_of_birth' => fake()->date(),
        //         'phone' => '0123456789',
        //         'address' => fake()->address(),
        //     ],
        //     [
        //         'name' => 'Support',
        //         'email' => 'support@gmail.com',
        //         'password' => Hash::make('123123'),
        //         'user_flg' => 2,
        //         'date_of_birth' => fake()->date(),
        //         'phone' => '0123456789',
        //         'address' => fake()->address(),
        //     ],
        // ]);
        User::factory()->times(50)->create();
    }
}
