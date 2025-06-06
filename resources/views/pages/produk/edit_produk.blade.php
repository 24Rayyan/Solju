@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Edit Produk</h1>

    <form action="{{ route('produk.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block">Kode Produk</label>
            <input type="text" name="product_code" value="{{ $product->product_code }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block">Harga</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('produk.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
