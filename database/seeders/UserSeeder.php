<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'User',
            'birthdate' => '2000-01-01',
            'email' => 'abc@mail.com',
            'password' => Hash::make('1234')
        ]);

        DB::table('users')->insert([
            'name' => 'User Test',
            'birthdate' => '1999-05-23',
            'email' => 'abc_2@mail.com',
            'password' => Hash::make('1234')
        ]);
    }
}
