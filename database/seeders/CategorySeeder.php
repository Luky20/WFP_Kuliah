<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Appetizer',
            'Main Course',
            'Snack',
            'Dessert',
            'Coffee',
            'Non-Coffee',
            'Healthy Juice',
        ];

        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $name = $categories[$i % count($categories)];
            $data[] = [
                'name'       => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($data);
    }
}
