<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Pan',
            'description' => 'Piezas de pan dulce',
            'stock' => 20,
            'price' => 8.50
        ]);

        DB::table('products')->insert([
            'name' => 'Refresco',
            'description' => 'Botellas de refresco',
            'stock' => 36,
            'price' => 17
        ]);

        DB::table('products')->insert([
            'name' => 'Sabritas',
            'description' => 'Frituras de maiz',
            'stock' => 28,
            'price' => 13.50
        ]);

        DB::table('products')->insert([
            'name' => 'Galletas',
            'description' => 'Galletas con chispas de chocolate',
            'stock' => 12,
            'price' => 14
        ]);
    }
}
