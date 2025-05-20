@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">📦 Daftar Order</h1>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <a href="{{ route('orders.create') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-medium py-2 px-4 rounded-lg transition-all shadow-md w-full md:w-auto text-center">
            ➕ Tambah Order
        </a>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('orders.index') }}" class="flex w-full md:w-auto">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari Nama Pelanggan"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm"
            />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 text-sm">
                Cari
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
        <table class="min-w-full bg-white">
            <thead class="bg-blue-100 text-gray-700 text-sm">
                <tr>
                    <th class="text-left px-6 py-3">Invoice</th>
                    <th class="text-left px-6 py-3">Nama</th>
                    <th class="text-left px-6 py-3">Alamat</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($orders as $order)
                    <tr class="border-t hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4">{{ $order->invoice_number }}</td>
                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4">{{ $order->customer_address }}</td>
                        <td class="px-6 py-4 text-center space-x-1 whitespace-nowrap">
                            <!-- Detail -->
                            <a href="{{ route('orders.show', $order) }}" class="inline-block text-green-600 hover:text-green-700">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('orders.edit', $order) }}" class="inline-block text-yellow-500 hover:text-yellow-600">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Hapus -->
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                            <!-- Download -->
                            <a href="{{ route('orders.downloadInvoice', $order) }}" class="inline-block text-blue-500 hover:text-blue-600">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
