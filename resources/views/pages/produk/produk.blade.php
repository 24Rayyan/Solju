@extends('layouts.app')

@section('menu')
<div class="flex items-center space-x-4 text-sm text-gray-500">
    <i class="fas fa-home text-lg text-gray-400"></i>
    <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
    <span class="text-gray-700 font-semibold">Produk</span>
</div>
@endsection

@section('content')
<div class="container mx-auto p-4 font-sans">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Daftar Produk</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">List Produk</h2>
            </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">NO</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KODE PRODUK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL PRODUK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">HARGA</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $index => $product)
                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $product->product_code }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="#" class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out" title="View Detail">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <a href="{{ route('produk.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out" title="Edit">
                                    <i class="fas fa-pencil-alt text-lg"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out focus:outline-none" title="Delete">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
