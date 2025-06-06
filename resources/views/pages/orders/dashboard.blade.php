@extends('layouts.app')

@section('menu')
    <p style="font-size:30px">Dashboard</p>
    <p style="font-weight: 100; font-size: 16px;">Selamat datang Admin!</p>
@endsection

@section('content')
<div class="flex rounded-lg border border-gray-300 overflow-hidden w-fit">
    @foreach (['12 bulan', '30 hari', '7 hari', '24 jam'] as $item)
        <a href="{{ route('dashboard.index', ['filter' => str_replace(' ', '', $item)]) }}"
            class="px-4 py-2 text-sm font-medium whitespace-nowrap
                   {{ $filter == str_replace(' ', '', $item) ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-50' }}
                   {{ !$loop->last ? 'border-r border-gray-300' : '' }}">
            {{ $item }}
        </a>
    @endforeach
</div>

<div class="flex gap-10" style="margin-top:24px">
    <div class="bg-white p-4 rounded shadow w-[360px]" style="border-radius: 15px;">
        <h2 class="text-lg font-semibold">Invoice Belum Lunas</h2>
        <p class="text-2xl font-bold text-red-600">{{ $invoiceBelumLunas }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow w-[360px]" style="border-radius: 15px;">
        <h2 class="text-lg font-semibold">Total Produk Terjual</h2>
        <p class="text-2xl font-bold text-blue-600">{{ $totalProdukTerjual }} <span style="color: black; font-size: 14px">Karton</span></p>
    </div>
    <div class="bg-white p-4 rounded shadow w-[360px]" style="border-radius: 15px;">
        <h2 class="text-lg font-semibold">Invoice Lunas</h2>
        <p class="text-2xl font-bold text-green-600">{{ $invoiceLunas }}</p>
    </div>
</div>
<br>
<br>
 <!-- Chart Container -->
    <div class="bg-white shadow rounded p-4 w-[1160px] h-[500px]">
        <div class="mb-4">
    <h3 class="text-lg font-semibold" style="margin-bottom:12px">Total Pemasukan</h3>
    <div class="text-3xl font-bold">
        Rp{{ number_format($currentIncome, 0, ',', '.') }}
        @if($percentageChange !== 0)
            <span class="{{ $percentageChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                {{ $percentageChange >= 0 ? '↑' : '↓' }}{{ number_format(abs($percentageChange), 1) }}%
            </span>
        @endif
    </div>
    <div class="text-sm text-gray-500" style="margin-top: 12px;">
        vs {{ $filter }} sebelumnya. Rp{{ number_format($previousIncome, 0, ',', '.') }}
    </div>
    </div>
        <canvas id="penjualanChart" width="1096" height="350"></canvas>
    </div>

</div>

<div class="bg-white shadow rounded-lg p-4 mt-6 w-[1190px]">
    <h3 class="text-lg font-semibold mb-4">Top Product</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-600 text-sm">
                <tr>
                    <th class="px-4 py-2 text-left ">NO</th>
                    <th class="px-4 py-2 text-left">PRODUCT</th>
                    <th class="px-4 py-2 text-center">TOTAL PRODUK TERJUAL</th>
                    <th class="px-4 py-2 text-right">NOMINAL</th>
                </tr>
            </thead>
            <tbody class="text-gray-800 text-sm divide-y divide-gray-200">
                @foreach ($topProducts as $index => $product)
                    <tr>
                        <td class="px-4 py-2" style="color:#475467">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-2 text-center text-gray-600">{{ $product->total_terjual }}</td>
                        <td class="px-4 py-2 text-right text-gray-600">
                            Rp{{ number_format($product->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

                @if ($topProducts->isEmpty())
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500 italic">
                            Tidak ada data produk terjual.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('penjualanChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($penjualan->pluck('period')) !!},
            datasets: [{
                label: 'Total Penjualan',
                data: {!! json_encode($penjualan->pluck('total')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
