<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillHasDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil food & price (diasumsikan ada kolom price di foods)
        $foodPriceMap = DB::table('foods')->pluck('price', 'id')->all();
        $foodIds      = array_keys($foodPriceMap);

        if (empty($foodIds)) {
            throw new \RuntimeException('Seed foods terlebih dahulu (dengan kolom price).');
        }

        // Proses bills non-draft per chunk
        $CHUNK = 1000;

        DB::table('bills')
            ->where('status', '!=', 'draft')
            ->orderBy('id')
            ->chunk($CHUNK, function ($bills) use ($foodIds, $foodPriceMap) {

                $detailRows = [];
                $billTotals = [];

                foreach ($bills as $bill) {
                    // Barang per nota: 1..10 (tanpa duplikat food di satu bill)
                    $itemCount = random_int(1, 10);
                    $itemCount = min($itemCount, count($foodIds));

                    $pickedIdx = (array) array_rand($foodIds, $itemCount);
                    if (!is_array($pickedIdx)) $pickedIdx = [$pickedIdx];

                    $sum = 0;

                    foreach ($pickedIdx as $idx) {
                        $foodId    = $foodIds[$idx];
                        $qty       = random_int(1, 50); // qty per detail: 1..50
                        $unitPrice = (float) ($foodPriceMap[$foodId] ?? 0);

                        $detailRows[] = [
                            'bill_id'  => $bill->id,
                            'food_id'  => $foodId,
                            'quantity' => $qty,
                            'price'    => $unitPrice,
                        ];

                        $sum += $qty * $unitPrice;
                    }

                    $billTotals[$bill->id] = $sum;
                }

                if (!empty($detailRows)) {
                    foreach (array_chunk($detailRows, 5000) as $slice) {
                        DB::table('bill_has_detail')->insert($slice);
                    }
                }

                foreach ($billTotals as $billId => $total) {
                    DB::table('bills')->where('id', $billId)->update([
                        'total_amount' => $total,
                    ]);
                }
            });

        DB::table('bills')->where('status', 'draft')->update(['total_amount' => 0]);
    }
}
