<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 24000) as $i) { 
            DB::table('customers')->insert([
                'name'      => $faker->name,
                'gender'    => $faker->randomElement(['male', 'female']),
                'city'      => $faker->city,
                'phone'     => $faker->phoneNumber,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
