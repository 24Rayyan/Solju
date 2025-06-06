@extends('layouts.app')

@section('menu')
<div class="flex items-center space-x-4 text-sm text-gray-500">
    <i class="fas fa-home text-lg text-gray-400"></i>
    <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
    <span class="text-gray-300 font-semibold">Daftar Produk</span>
    <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
    <span class="text-gray-700 font-semibold">Tambah Produk</span>
</div>
@endsection

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Tambah Produk</h1>

    <form action="{{ route('produk.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Kode Produk</label>
            <input type="text" name="product_code" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block">Nama Produk</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block">Harga</label>
            <input type="number" name="price" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('produk.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
