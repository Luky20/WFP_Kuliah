{{-- resources/views/latihan/index.blade.php --}}
@extends('app')

@section('title', 'Laporan Penjualan')

@section('content')
@php($num = $num ?? 1)

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Laporan Penjualan</h1>

        {{-- Picker Nomor 1–10 --}}
        <div class="btn-group" role="group" aria-label="Picker Soal">
            @for ($i = 1; $i <= 10; $i++)
                <a href="{{ route('latihan.show', ['num' => $i]) }}"
                   class="btn btn-sm {{ $i == $num ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $i }}
                </a>
            @endfor
        </div>
    </div>

    {{-- Tombol Prev / Next --}}
    <div class="d-flex justify-content-between mb-4">
        @if($num > 1)
            <a href="{{ route('latihan.show', ['num' => $num - 1]) }}" class="btn btn-outline-secondary">
                &laquo; Sebelumnya
            </a>
        @else
            <span></span>
        @endif

        @if($num < 10)
            <a href="{{ route('latihan.show', ['num' => $num + 1]) }}" class="btn btn-primary">
                Berikutnya &raquo;
            </a>
        @endif
    </div>

    {{-- ================= Soal #1 ================= --}}
    @if($num == 1)
        <h2 class="h5 mt-2">1. Top 5 Barang Paling Laku</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Barang</th>
                <th>Total Qty</th>
                <th>Total Penjualan</th>
                <th>Jumlah Nota</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no1 ?? collect()) as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->name ?? '-' }}</td>
                    <td>{{ $row->total_qty ?? 0 }}</td>
                    <td>Rp {{ number_format($row->total_sales ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->bill_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #2 ================= --}}
    @if($num == 2)
        <h2 class="h5 mt-2">2. Top 1 Kategori Paling Laku</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Kategori</th>
                <th>Total Qty</th>
                <th>Total Penjualan</th>
                <th>Jumlah Nota</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no2 ?? collect()) as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->name ?? '-' }}</td>
                    <td>{{ $row->total_qty ?? 0 }}</td>
                    <td>Rp {{ number_format($row->total_sales ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->bill_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #3 ================= --}}
    @if($num == 3)
        <h2 class="h5 mt-2">3. Top 3 Spender (Nominal Pembelian Terbanyak)</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Total Qty</th>
                <th>Total Pembelian</th>
                <th>Jumlah Nota</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no3 ?? collect()) as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->name ?? '-' }}</td>
                    <td>{{ $row->total_qty ?? 0 }}</td>
                    <td>Rp {{ number_format($row->total_sales ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->bill_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #4 ================= --}}
    @if($num == 4)
        <h2 class="h5 mt-2">4. Top Buyer (Total Item Terbanyak)</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Total Item (Qty)</th>
                <th>Total Pembelian</th>
                <th>Jumlah Nota</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no4 ?? collect()) as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->name ?? '-' }}</td>
                    <td>{{ $row->total_qty ?? 0 }}</td>
                    <td>Rp {{ number_format($row->total_sales ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->bill_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #5 ================= --}}
    @if($num == 5)
        <h2 class="h5 mt-2">5. Nota > Rata-rata Total Bulanan (tampilkan nama pembeli)</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer</th>
                <th>No. Nota</th>
                <th>Tanggal</th>
                <th>Total Nota</th>
                <th>Rata-rata Bulan</th>
                <th>Bulan</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no5 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->customer_name ?? '-' }}</td>
                    <td>{{ $row->bill_number ?? '-' }}</td>
                    <td>{{ $row->bill_date ?? '-' }}</td>
                    <td>Rp {{ number_format($row->bill_total ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->monthly_avg ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->month_label ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #6 ================= --}}
    @if($num == 6)
        <h2 class="h5 mt-2">6. Rata-rata Total Pembelian 3 Bulan Terakhir</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Bulan</th>
                <th>Rata-rata Total Pembelian</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no6 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->month_label ?? '-' }}</td>
                    <td>Rp {{ number_format($row->avg_total ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #7 ================= --}}
    @if($num == 7)
        <h2 class="h5 mt-2">7. Total Pembelian Terbesar per Pelanggan (Wanita)</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Customer</th>
                <th>Gender</th>
                <th>No. Nota</th>
                <th>Tanggal</th>
                <th>Total Terbesar</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no7 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->customer_name ?? '-' }}</td>
                    <td>{{ $row->gender ?? '-' }}</td>
                    <td>{{ $row->bill_number ?? '-' }}</td>
                    <td>{{ $row->bill_date ?? '-' }}</td>
                    <td>Rp {{ number_format($row->max_total ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #8 ================= --}}
    @if($num == 8)
        <h2 class="h5 mt-2">8. Barang dengan Rata-rata Penjualan (Qty) Terkecil</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Barang</th>
                <th>Rata-rata Qty / Nota</th>
                <th>Total Qty</th>
                <th>Total Penjualan</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no8 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->name ?? '-' }}</td>
                    <td>{{ number_format($row->avg_qty ?? 0, 2, ',', '.') }}</td>
                    <td>{{ $row->total_qty ?? 0 }}</td>
                    <td>Rp {{ number_format($row->total_sales ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #9 ================= --}}
    @if($num == 9)
        <h2 class="h5 mt-2">9. Karyawan dengan Rata-rata Penjualan Terbesar per Bulan</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Bulan</th>
                <th>Karyawan</th>
                <th>Rata-rata Penjualan</th>
                <th>Jumlah Nota</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no9 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->month_label ?? '-' }}</td>
                    <td>{{ $row->employee_name ?? '-' }}</td>
                    <td>Rp {{ number_format($row->avg_sales ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->bill_count ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= Soal #10 ================= --}}
    @if($num == 10)
        <h2 class="h5 mt-2">10. Daftar Karyawan Penerima Bonus Tahunan</h2>
        <p class="text-muted small mb-2">
            Rumus: Bonus Tahunan = (10% × total penjualan terbesar per bulan) + (5% × total penjualan yang > rata-rata tahunan).
        </p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Karyawan</th>
                <th>Total Penjualan Tahunan</th>
                <th>Komponen 10%</th>
                <th>Komponen 5%</th>
                <th>Total Bonus</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($no10 ?? collect()) as $row)
                <tr>
                    <td>{{ $row->employee_name ?? '-' }}</td>
                    <td>Rp {{ number_format($row->year_total_sales ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->component_max10 ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->component_above5 ?? 0, 0, ',', '.') }}</td>
                    <td class="fw-bold">Rp {{ number_format($row->bonus_total ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    @endif

    <div class="d-flex justify-content-between my-4">
        @if($num > 1)
            <a href="{{ route('latihan.show', ['num' => $num - 1]) }}" class="btn btn-outline-secondary">
                &laquo; Sebelumnya
            </a>
        @else
            <span></span>
        @endif

        @if($num < 10)
            <a href="{{ route('latihan.show', ['num' => $num + 1]) }}" class="btn btn-primary">
                Berikutnya &raquo;
            </a>
        @endif
    </div>
</div>
@endsection
