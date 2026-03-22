<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'Nike',
                'status' => 1,
            ],
            [
                'name' => 'Adidas',
                'status' => 1,
            ],
            [
                'name' => 'Puma',
                'status' => 1,
            ],
        ]);
    }
}
