<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([
            ['name' => 'XS', 'status' => 1],
            ['name' => 'S',  'status' => 1],
            ['name' => 'M',  'status' => 1],
            ['name' => 'L',  'status' => 1],
            ['name' => 'XL', 'status' => 1],
            ['name' => 'XXL', 'status' => 1],
            ['name' => 'XXXL', 'status' => 1],
        ]);
    }
}
