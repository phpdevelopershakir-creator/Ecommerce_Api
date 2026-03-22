<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Black', 'code' => '#000000', 'status' => 1],
            ['name' => 'White', 'code' => '#FFFFFF', 'status' => 1],
            ['name' => 'Red', 'code' => '#FF0000', 'status' => 1],
            ['name' => 'Blue', 'code' => '#0000FF', 'status' => 1],
            ['name' => 'Green', 'code' => '#008000', 'status' => 1],
            ['name' => 'Yellow', 'code' => '#FFFF00', 'status' => 1],
            ['name' => 'Gray', 'code' => '#808080', 'status' => 1],
            ['name' => 'Orange', 'code' => '#FFA500', 'status' => 1],
        ]);
    }
}
