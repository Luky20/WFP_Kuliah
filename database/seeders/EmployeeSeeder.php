<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $i) {
            DB::table('employees')->insert([
                'name'       => $faker->name,
                'gender'     => $faker->randomElement(['male', 'female']),
                'position'   => $faker->randomElement(['manager', 'cashier', 'cook']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
