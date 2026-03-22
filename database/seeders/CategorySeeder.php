<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Men',
                'status' => 1,
                'home_category' => 0,
            ],
            [
                'name' => 'Women',
                'status' => 1,
                'home_category' => 0,
            ],
            [
                'name' => 'Kids',
                'status' => 1,
                'home_category' => 0,
            ],
        ]);
    }
}
