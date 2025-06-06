@extends('layouts.app')

@section('menu')
    <div class="flex items-center" style="gap: 12px;">
        <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold" style="font-size: 14px;">Manajemen Order</span>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6" style="margin-bottom: 47px">
            <P class="text-lg md:text-xl font-semibold text-gray-900" style="font-size: 30px">Manajemen Order</P>
            <a href="{{ route('orders.create') }}"
                class="flex items-center bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 text-sm font-semibold"
                style="height: 52px;">
                <i class="fa-solid fa-plus" style=" margin-right:16px"></i><span style="font-size:16px;">Tambah Order</span>
            </a>
        </div>

        <div class="overflow-x-auto border rounded-xl shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 bg-white">
                <span style="margin-left: 24px; margin-top:20px; margin-bottom:20px"><strong>List Order</strong></span>
                <form method="GET" action="{{ route('orders.index') }}" class="flex w-full md:w-auto items-center"
                    style="margin-right: 24px">
                    <div class="relative flex items-center w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 text-gray-500"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                            class="w-full md:w-80 pl-10 pr-4 py-2 border border-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm" />
                    </div>
                </form>
            </div>
            <table class="min-w-full bg-white text-sm">
                <thead class="text-left text-gray-500 bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center">NO INVOICE</th>
                        <th class="px-6 py-3 text-center">NAMA</th>
                        <th class="px-6 py-3 text-center">ALAMAT</th>
                        <th class="px-6 py-3 text-center">STATUS</th>
                        <th class="px-6 py-3 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($orders as $index => $order)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-6 py-4 text-center">{{ $order->invoice_number }}</td>
                            <td class="px-6 py-4 text-center"><strong>{{ $order->customer_name }}</strong></td>
                            <td class="px-6 py-4 ">{{ $order->customer_address }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($order->payment_proof)
                                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">Lunas</span>
                                @else
                                    <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Belum bayar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('orders.show', $order) }}" class="text-gray-500 hover:text-gray-700"><i
                                        class="fas fa-eye"></i></a>
                                @if ($order->payment_proof)
                                @else
                                    <a href="{{ route('orders.edit', $order) }}"
                                        class="text-gray-500 hover:text-yellow-500"><i class="fas fa-edit"></i></a>
                                @endif
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-500"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ route('orders.downloadInvoice', $order) }}"
                                    class="text-gray-500 hover:text-blue-500"><i class="fas fa-download"></i></a>
                                @if ($order->payment_proof)
                                    <a href="{{ route('orders.bukti', $order) }}"
                                        class="text-gray-500 hover:text-green-600"><i class="fas fa-file-check"></i></a>
                                @else
                                    <a href="{{ route('orders.payment', $order) }}"
                                        class="text-gray-500 hover:text-yellow-600"><i class="fas fa-wallet"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination & Data Info -->
        <div class="flex flex-col md:flex-row items-center justify-between mt-4 text-sm text-gray-500">
            <div>
                Show Data
                <select onchange="location.href='?perPage='+this.value+'&search={{ request('search') }}'"
                    class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                </select>
            </div>
            <div>
                Showing {{ $orders->firstItem() }} - {{ $orders->lastItem() }} of {{ $orders->total() }} Data
            </div>
            <div>
                {{ $orders->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
@endsection
