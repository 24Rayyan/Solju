@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-8"> {{-- Added mb-8 for spacing below menu --}}
        <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-300 font-semibold" style="font-size: 14px;">Keuangan</span>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold">Bukti Upload</span>
    </div>
@endsection

@section('content')
    <div class="min-h-screen py-4 font-sans">
        <div class="max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8"> {{-- Added horizontal padding for smaller screens --}}

            <div class="mb-8 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Rincian Pesanan</h2>
                <div class="space-y-2 text-lg text-gray-700">
                    <p><strong>Invoice No:</strong> {{ $order->invoice_number }}</p>
                    <p><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Alamat Pelanggan:</strong> {{ $order->customer_address }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div class="md:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Produk</h2>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">Nama Produk</th>
                                    <th class="px-4 py-3 text-left">Jumlah</th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 text-gray-700">{{ $product->name }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $product->quantity }}</td>
                                        <td class="px-4 py-3 text-gray-700">Rp
                                            {{ number_format($product->quantity * $product->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 text-right">
                        <p class="text-lg font-semibold text-gray-800">
                            Grand Total :
                            Rp {{ number_format($order->products->sum(fn($p) => $p->quantity * $p->price), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="md:col-span-1 bg-white rounded-xl shadow-lg p-6 flex flex-col items-center justify-center text-center">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Bukti Pembayaran</h2>
                    @if ($order->payment_proof)
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" rel="noopener noreferrer" class="w-full">
                            <div class="w-full h-64 overflow-hidden rounded-lg shadow-md mb-4">
                                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran"
                                    class="w-full h-full object-cover cursor-pointer">
                            </div>
                        </a>
                        <p class="text-gray-600 font-medium">Bukti pembayaran telah diunggah</p>
                    @else
                        <div class="text-red-500 text-lg font-medium mb-4">
                            <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2">Belum ada bukti pembayaran.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <a href="{{ route('orders.index') }}"
                    class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300 shadow">
                    Kembali 
                </a>
            </div>
        </div>
    </div>
@endsection