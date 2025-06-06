@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500">
        <img src="{{ asset('resources/asset/keuangan.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold" style="font-size: 14px;">Keuangan</span>
    </div>
@endsection

@section('content')
    <div class="px-8 py-6">
        <h1 class="text-2xl font-semibold mb-4">Keuangan</h1>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium">History Keuangan</h2>
                <form method="GET" action="{{ route('keuangan.search') }}" class="relative w-72">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm" />
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-t border-gray-200">
                    <thead class="text-gray-700 bg-gray-50 uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">No Invoice</th>
                            <th class="px-4 py-3">Nama Reseller</th>
                            <th class="px-4 py-3 text-center">Total Produk</th>
                            <th class="px-4 py-3 ">Harga</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @forelse($orders as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                <td class="px-4 py-3">{{ $item['invoice_number'] }}</td>
                                <td class="px-4 py-3">{{ $item['customer_name'] }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->products->sum('quantity') }} Karton</td>
                                <td class="px-4 py-3 ">
                                    Rp{{ number_format(
                                        $item->products->sum(function ($product) {
                                            return $product->quantity * $product->price;
                                        }),
                                        2,
                                        ',',
                                        '.',
                                    ) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center" style="margin-right: 50%">
                                        <a href="{{ route('orders.bukti', $item->id) }}"
                                            class="text-black-500 hover:text-red-700"><i class="far fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
@endsection
