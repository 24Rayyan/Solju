@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500">
        <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-300 font-semibold" style="font-size: 14px;">Manajemen Order</span>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold">Detail Order</span>
    </div>
@endsection

@section('content')
    {{-- Main container, adjusted padding to match the edit page --}}
    <div class="px-6 py-8">
        {{-- Top section: Title and action buttons, mimicking the edit page layout --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Detail Order - Invoice #{{ $order->invoice_number }}</h2>
            <div class="flex space-x-4">
                <a href="{{ route('orders.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">Kembali</a>
                <a href="{{ route('orders.downloadInvoice', $order) }}"
                    class="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition-colors shadow-md">
                    <i class="fa-solid fa-download" style="margin-right: 10px"></i>Download Invoice
                </a>
            </div>
        </div>

        {{-- Main content card --}}
        <div class="bg-white rounded-xl p-6 shadow-md space-y-6">
            <div class="space-y-4"> {{-- Added space-y for consistent spacing --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                    <p class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-50 text-gray-800">
                        {{ $order->customer_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Customer</label>
                    <p class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-50 text-gray-800">
                        {{ $order->customer_address }}</p>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-800 mb-4">Produk yang Dibeli</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200"> {{-- Applied rounded border to table wrapper --}}
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700"> {{-- Changed header background to grey --}}
                        <tr>
                            <th class="px-4 py-3 text-left">Nama Produk</th>
                            <th class="px-4 py-3 text-left">Jumlah</th>
                            <th class="px-4 py-3 text-left">Harga Satuan</th>
                            <th class="px-4 py-3 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700">{{ $product->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $product->quantity }}</td>
                                <td class="px-4 py-3 text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td> {{-- Changed to 0 decimal places for consistency with edit page total --}}
                                <td class="px-4 py-3 text-gray-700">Rp
                                    {{ number_format($product->quantity * $product->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <p class="text-lg font-semibold text-gray-800">
                    <strong>Total Keseluruhan:</strong>
                    Rp {{ number_format($order->products->sum(fn($p) => $p->quantity * $p->price), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
@endsection