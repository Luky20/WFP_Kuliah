@extends('app')

@section('title', 'Daftar Makanan')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Makanan</h1>

    {{-- Tabel Food --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foods as $food)
                <tr>
                    <td>{{ $food->name }}</td>
                    <td>{{ $food->description }}</td>
                    <td>Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                    <td>{{ $food->category->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
</div>
@endsection
