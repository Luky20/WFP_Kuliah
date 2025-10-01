<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function show(int $num = 1)
    {
        $num = max(1, min(10, $num));

        // Inisialisasi kosong agar blade aman
        $no1 = $no2 = $no3 = collect();
        $no4 = $no5 = $no6 = $no7 = $no8 = $no9 = $no10 = collect();
        // siapkan juga placeholder untuk 4..10 bila nanti ditambahkan
        // $no4 = $no5 = ... = collect();

        switch ($num) {
            case 1:
                // 1) Top 5 Barang Paling Laku (hanya bills status paid/sent)
                $no1 = DB::table('bill_has_detail as bd')
                    ->join('bills as b', 'b.id', '=', 'bd.bill_id')
                    ->join('foods as f', 'f.id', '=', 'bd.food_id')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('f.id', 'f.name')
                    ->select(
                        'f.id',
                        'f.name',
                        DB::raw('SUM(bd.quantity) AS total_qty'),
                        DB::raw('SUM(bd.quantity * bd.price) AS total_sales'),
                        DB::raw('COUNT(DISTINCT b.id) AS bill_count')
                    )
                    ->orderByDesc('total_qty')
                    ->limit(5)
                    ->get();
                break;

            case 2:
                // 2) Top 1 kategori paling laku (paid/sent)
                $no2 = DB::table('foods as f')
                    ->join('categories as c', 'f.category_id', '=', 'c.id')
                    ->join('bill_has_detail as bd', 'f.id', '=', 'bd.food_id')
                    ->join('bills as b', 'b.id', '=', 'bd.bill_id')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('c.id', 'c.name')
                    ->select(
                        'c.id',
                        'c.name',
                        DB::raw('SUM(bd.quantity) AS total_qty'),
                        DB::raw('SUM(bd.quantity * bd.price) AS total_sales'),
                        DB::raw('COUNT(DISTINCT b.id) AS bill_count')
                    )
                    ->orderByDesc('total_qty')
                    ->limit(1)
                    ->get();
                break;

            case 3:
                // 3) Top 3 spender (total nominal terbesar, paid/sent)
                $no3 = DB::table('customers as c')
                    ->join('bills as b', 'b.customer_id', '=', 'c.id')
                    ->join('bill_has_detail as bd', 'bd.bill_id', '=', 'b.id')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('c.id', 'c.name')
                    ->select(
                        'c.id',
                        'c.name',
                        DB::raw('SUM(bd.quantity) AS total_qty'),
                        DB::raw('SUM(bd.quantity * bd.price) AS total_sales'),
                        DB::raw('COUNT(DISTINCT b.id) AS bill_count')
                    )
                    ->orderByDesc('total_sales')
                    ->limit(3)
                    ->get();
                break;
            
            case 4:
                 $no4 = DB::table('customers as c')
                    ->join('bills as b', 'b.customer_id', '=', 'c.id')
                    ->join('bill_has_detail as bd', 'bd.bill_id', '=', 'b.id')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('c.id', 'c.name')
                    ->select(
                        'c.id',
                        'c.name',
                        DB::raw('SUM(bd.quantity) AS total_qty'),
                        DB::raw('SUM(bd.quantity * bd.price) AS total_sales'),
                        DB::raw('COUNT(DISTINCT b.id) AS bill_count')
                    )
                    ->orderByDesc('total_qty')
                    ->limit(1)
                    ->get();
                return view('latihan.index', [
                    'num' => 4,
                    'no4' => $no4,
                    // supaya blade aman meski variabel lain kosong:
                    'no1' => collect(), 'no2' => collect(), 'no3' => collect(),
                ]);
            case 5:
                // 5) Nota dengan total > rata-rata bulan yang sama (tampilkan nama pembeli)
                $monthlyAvg = DB::table('bills')
                    ->whereIn('status', ['paid', 'sent'])
                    ->selectRaw("DATE_FORMAT(bill_date, '%Y-%m') AS ym, AVG(total_amount) AS monthly_avg")
                    ->groupBy('ym');

                $no5 = DB::table('bills as b')
                    ->join('customers as c', 'c.id', '=', 'b.customer_id')
                    ->joinSub($monthlyAvg, 'ma', function ($join) {
                        $join->on(DB::raw("DATE_FORMAT(b.bill_date, '%Y-%m')"), '=', 'ma.ym');
                    })
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->whereColumn('b.total_amount', '>', 'ma.monthly_avg')
                    ->select(
                        'c.name as customer_name',
                        'b.bill_number',
                        'b.bill_date',
                        DB::raw('b.total_amount AS bill_total'),
                        DB::raw('ma.monthly_avg'),
                        DB::raw("DATE_FORMAT(b.bill_date, '%Y-%m') AS month_label")
                    )
                    ->orderByDesc('b.bill_date')
                    ->get();
                break;
            case 6:
                    // 6) Rata-rata total pembelian 3 bulan terakhir (per bulan)
                    $start = Carbon::now()->startOfMonth()->subMonths(3);
                    $end   = Carbon::now()->endOfDay();

                    $no6 = DB::table('bills as b')
                        ->whereBetween('b.bill_date', [$start->toDateString(), $end->toDateString()])
                        ->whereIn('b.status', ['paid', 'sent'])
                        ->groupByRaw("DATE_FORMAT(b.bill_date, '%Y-%m')")
                        ->selectRaw("DATE_FORMAT(b.bill_date, '%Y-%m') AS month_label, AVG(b.total_amount) AS avg_total")
                        ->orderBy('month_label', 'desc')
                        ->limit(3)
                        ->get();
                break;
            case 7:
                // 7) Total pembelian terbesar per pelanggan (Wanita)
                $maxPerFemale = DB::table('bills as b')
                    ->join('customers as c', 'c.id', '=', 'b.customer_id')
                    ->where('c.gender', 'female')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('b.customer_id')
                    ->select('b.customer_id', DB::raw('MAX(b.total_amount) AS max_total'));

                $no7 = DB::table('bills as b')
                    ->joinSub($maxPerFemale, 'm', function ($join) {
                        $join->on('m.customer_id', '=', 'b.customer_id')
                             ->on('m.max_total', '=', 'b.total_amount');
                    })
                    ->join('customers as c', 'c.id', '=', 'b.customer_id')
                    ->select(
                        'c.name as customer_name',
                        'b.bill_number',
                        'b.bill_date',
                        'c.gender',
                        DB::raw('m.max_total AS max_total')
                    )
                    ->orderByDesc('m.max_total')
                    ->get();
                break;

            case 8:
                // 8) Barang dengan rata-rata penjualan (qty) terkecil
                $no8 = DB::table('bill_has_detail as bd')
                    ->join('bills as b', 'b.id', '=', 'bd.bill_id')
                    ->join('foods as f', 'f.id', '=', 'bd.food_id')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('f.id', 'f.name')
                    ->select(
                        'f.id',
                        'f.name',
                        DB::raw('AVG(bd.quantity) AS avg_qty'),
                        DB::raw('SUM(bd.quantity) AS total_qty'),
                        DB::raw('SUM(bd.quantity * bd.price) AS total_sales')
                    )
                    ->orderBy('avg_qty', 'asc')
                    ->limit(1)
                    ->get();
                break;

            case 9:
                // 9) Karyawan dengan rata-rata penjualan terbesar di setiap bulan
                $empMonth = DB::table('bills as b')
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupByRaw("DATE_FORMAT(b.bill_date, '%Y-%m'), b.employee_id")
                    ->selectRaw("
                        DATE_FORMAT(b.bill_date, '%Y-%m') AS ym,
                        b.employee_id,
                        AVG(b.total_amount) AS avg_sales,
                        COUNT(*) AS bill_count
                    ");

                $maxPerMonth = DB::query()
                    ->fromSub($empMonth, 'em')
                    ->groupBy('ym')
                    ->selectRaw('ym, MAX(avg_sales) AS max_avg');

                $no9 = DB::query()
                    ->fromSub($empMonth, 'em')
                    ->joinSub($maxPerMonth, 'mx', function ($join) {
                        $join->on('em.ym', '=', 'mx.ym')
                             ->on('em.avg_sales', '=', 'mx.max_avg');
                    })
                    ->join('employees as e', 'e.id', '=', 'em.employee_id')
                    ->select(
                        DB::raw('em.ym AS month_label'),
                        'e.name as employee_name',
                        DB::raw('em.avg_sales'),
                        DB::raw('em.bill_count')
                    )
                    ->orderBy('month_label', 'desc')
                    ->get();
                break;

            case 10:
                // 10) Bonus tahunan
                $year = Carbon::now()->year;

                $yearTotals = DB::table('bills as b')
                    ->whereYear('b.bill_date', $year)
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupBy('b.employee_id')
                    ->select('b.employee_id', DB::raw('SUM(b.total_amount) AS year_total_sales'));

                $maxBillPerEmpMonth = DB::table('bills as b')
                    ->whereYear('b.bill_date', $year)
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->groupByRaw("b.employee_id, DATE_FORMAT(b.bill_date, '%Y-%m')")
                    ->selectRaw("b.employee_id, DATE_FORMAT(b.bill_date, '%Y-%m') AS ym, MAX(b.total_amount) AS max_bill_month");

                $sumMaxPerEmpYear = DB::query()
                    ->fromSub($maxBillPerEmpMonth, 'mm')
                    ->groupBy('mm.employee_id')
                    ->selectRaw('mm.employee_id, SUM(mm.max_bill_month) AS sum_max_month');

                $annualAvg = DB::table('bills as b')
                    ->whereYear('b.bill_date', $year)
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->avg('b.total_amount') ?? 0;
                    
                $aboveSumPerEmp = DB::table('bills as b')
                    ->whereYear('b.bill_date', $year)
                    ->whereIn('b.status', ['paid', 'sent'])
                    ->where('b.total_amount', '>', $annualAvg)
                    ->groupBy('b.employee_id')
                    ->select('b.employee_id', DB::raw('SUM(b.total_amount) AS above_sum'));

                $no10 = DB::table('employees as e')
                    ->leftJoinSub($yearTotals, 'yt', 'yt.employee_id', '=', 'e.id')
                    ->leftJoinSub($sumMaxPerEmpYear, 'mx', 'mx.employee_id', '=', 'e.id')
                    ->leftJoinSub($aboveSumPerEmp, 'ab', 'ab.employee_id', '=', 'e.id')
                    ->select(
                        'e.id',
                        'e.name as employee_name',
                        DB::raw('COALESCE(yt.year_total_sales, 0) AS year_total_sales'),
                        DB::raw('COALESCE(mx.sum_max_month, 0) * 0.10 AS component_max10'),
                        DB::raw('COALESCE(ab.above_sum, 0) * 0.05 AS component_above5'),
                        DB::raw('(COALESCE(mx.sum_max_month, 0) * 0.10 + COALESCE(ab.above_sum, 0) * 0.05) AS bonus_total')
                    )
                    ->orderByDesc('bonus_total')
                    ->get();
                break;

            default:
                break;
        }

        return view('latihan.index', compact('num', 'no1', 'no2', 'no3', 'no4', 'no5',
         'no6', 'no7', 'no8', 'no9', 'no10'));
    }
}
