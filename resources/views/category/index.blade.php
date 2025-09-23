@extends('app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Kategori</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $i => $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('d M Y') }}</td>
                </tr>
                @foreach($category->foods as $food)
                <tr>
                    <td></td>
                    <td>{{$food}}</td>
                </tr>
            @endforeach
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada kategori.</td>
                </tr>
            @endforelse
            
        </tbody>
    </table>
</div>
@endsection
