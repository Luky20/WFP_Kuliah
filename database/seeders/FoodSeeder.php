<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua category_id yang ada
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $foods = [];

        for ($i = 0; $i < 1000; $i++) {
            $foods[] = [
                'name'            => $faker->words(3, true),
                'description'     => $faker->sentence(10),
                'price'          => $faker->randomFloat(2, 5, 200),
                'nutrition_facts' => $faker->paragraph(5),
                'category_id'    => $faker->randomElement($categoryIds),
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        // Insert sekaligus biar lebih cepat
        DB::table('foods')->insert($foods);
    }
}
