<div class="w-64 bg-white shadow-lg p-6 mr-10">
    <img src="{{ asset('resources/IMG/solju.png') }}" alt="Logo Solju" style="width: 148px; height: 66px;">
    <nav class="space-y-4" style="margin-top: 34px">
        <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 rounded-lg transition">
            <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
            <span style="font-size: 16px; margin-left: 12px">Dashboard</span>
        </a>
        <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 rounded-lg transition"> <img src="{{ asset('resources/asset/order.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
            <span style="font-size: 16px; margin-left: 12px">Manajemen Order</span>
        </a>
        <a href="{{ route('produk.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 rounded-lg transition">
            <img src="{{ asset('resources/asset/daftar.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
            <span style="font-size: 16px; margin-left: 12px">Daftar Produk</span>
        </a>
        <a href="{{ route('keuangan.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 rounded-lg transition">
            <img src="{{ asset('resources/asset/keuangan.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
            <span style="font-size: 16px; margin-left: 12px">Keuangan</span>
        </a>
    </nav>
</div>
