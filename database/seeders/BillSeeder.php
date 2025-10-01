<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $customerIds = DB::table('customers')->pluck('id')->all();
        $employeeIds = DB::table('employees')->pluck('id')->all();

        if (empty($customerIds) || empty($employeeIds)) {
            throw new \RuntimeException('Seed customers & employees terlebih dahulu.');
        }

        // Distribusi status non-draft (tetap seperti sebelumnya)
        $weighted = [
            'unpaid','unpaid','unpaid','unpaid',   // 40%
            'sent','sent',                         // 20%
            'partially paid','partially paid',     // 20%
            'paid','paid',                         // 20%
        ];

        $TARGET = 500000;
        $BATCH  = 5000;
        $seq    = 1;

        for ($offset = 0; $offset < $TARGET; $offset += $BATCH) {
            $rows = [];

            for ($i = 0; $i < $BATCH && ($offset + $i) < $TARGET; $i++, $seq++) {
                // Random created_at 2024-01-01 s.d. 2025-09-30 (Asia/Jakarta ok)
                $createdAt = Carbon::instance(
                    $faker->dateTimeBetween('2024-01-01 00:00:00', '2025-09-30 23:59:59')
                );
                $billDate  = $createdAt->copy()->toDateString();

                $customerId = $customerIds[array_rand($customerIds)];
                $employeeId = $employeeIds[array_rand($employeeIds)];

                // Bill number unik; pakai tanggal created_at untuk variasi
                $billNumber = 'B-' . $createdAt->format('Ymd') . '-' . str_pad((string)$seq, 6, '0', STR_PAD_LEFT);

                // Mulai dari draft, lalu di-random: 5% tetap draft, sisanya ambil dari distribusi
                $status = (random_int(1, 100) <= 5)
                    ? 'draft'
                    : $weighted[array_rand($weighted)];

                $rows[] = [
                    'customer_id'  => $customerId,
                    'employee_id'  => $employeeId,
                    'bill_number'  => $billNumber,
                    'bill_date'    => $billDate,
                    'total_amount' => 0,
                    'status'       => $status,
                    'created_at'   => $createdAt,
                    'updated_at'   => $createdAt,
                ];
            }

            DB::table('bills')->insert($rows);
        }
    }
}
