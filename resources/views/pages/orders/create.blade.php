@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500">
        <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-300 font-semibold" style="font-size: 14px;">Manajemen Order</span>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold">Tambah Order</span>
    </div>
@endsection

@section('content')
    <div class="max-w-full mx-auto mt-10 px-4">
        <form action="{{ route('orders.store') }}" method="POST">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Tambah Order</h2>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-md"><i class="fa-solid fa-floppy-disk"
                        style="margin-right: 10px"></i>Simpan Order</button>
            </div>
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Reseller <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" class="w-full border border-gray-300 rounded-md px-4 py-2"
                        placeholder="Masukkan Reseller" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Reseller <span
                            class="text-red-500">*</span></label>
                    <textarea name="customer_address" rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2"
                        placeholder="Masukkan Alamat" required></textarea>
                </div>
            </div>

            <div class="mt-8 rounded-lg border border-gray-200 px-4 py-4 bg-white">
                <h3 class="text-lg font-medium mb-4">Produk <span class="text-red-500">*</span></h3>

                <table class="w-full border text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                    </tbody>
                </table>

                <div class="text-right mt-2">
                    <strong>Total Bayar:</strong> <span id="grand-total" class="ml-2">Rp 0</span>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-product"
                        class="w-full bg-black text-white px-4 py-2 rounded-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus" style=" margin-right:16px"></i><span
                            style="font-size:16px;">Tambah</span>
                    </button>
                </div>
            </div>
            <template id="product-row-template">
                <tr class="product-row border-b border-gray-200">
                    <td class="px-4 py-2 counter">1</td>
                    <td class="px-4 py-2">
                       <select class="product-select w-full px-2 py-1 border border-gray-300 rounded" required>
                            <option value="">Pilih produk</option>
                            {{-- BARIS INI YANG HARUS DIUBAH / DITAMBAHKAN --}}
                            @foreach ($products as $product)
                                <option value="{{ $product->name }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                            {{-- Pastikan Anda menghapus opsi-opsi hardcode sebelumnya seperti "Solju Grape", dll. --}}
                        </select>
                        <input type="hidden" name="products[][name]" class="product-name">
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="products[][quantity]"
                            class="product-quantity w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Jumlah" required>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="products[][price]"
                            class="product-price w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
                            readonly>
                    </td>
                    <td class="px-4 py-3 w-36 whitespace-nowrap">
                        <span class="total-price block text-right">0</span>
                    </td>
                    <td class="px-4 py-3">
                        <button type="button"
                            class="remove-product px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
                    </td>
                </tr>
            </template>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productList = document.getElementById('product-list');
            const addProductButton = document.getElementById('add-product');
            const template = document.getElementById('product-row-template').content;
            const grandTotalDisplay = document.getElementById('grand-total');

            // --- Hapus productIndex jika Anda ingin nomor baris otomatis dari 1 ---
            // let productIndex = 0; // Ini tidak diperlukan lagi untuk nomor urut tabel

            // Fungsi untuk memperbarui nomor urut di kolom "No"
            function updateRowNumbers() {
                const rows = productList.querySelectorAll('.product-row');
                rows.forEach((row, index) => {
                    row.querySelector('.counter').textContent = index + 1;
                });
            }

            addProductButton.addEventListener('click', function() {
                const newRow = document.importNode(template, true);

                // Pastikan name attribute unik untuk setiap baris produk saat disubmit
                // Anda mungkin ingin menggunakan indeks baris yang sebenarnya atau timestamp
                // untuk memastikan uniqueness jika order penting.
                // Untuk contoh ini, kita bisa menggunakan productList.children.length
                // untuk mendapatkan indeks baris saat ini.
                const currentRowCount = productList.children.length; // Hitung baris yang sudah ada
                
                newRow.querySelector('.product-select').name = `products[${currentRowCount}][name]`; // Ubah ini untuk nama select juga
                newRow.querySelector('input[name="products[][name]"]').name =
                    `products[${currentRowCount}][product_name]`; // Ganti dengan nama field yang lebih spesifik jika perlu, misal product_name
                newRow.querySelector('input[name="products[][quantity]"]').name =
                    `products[${currentRowCount}][quantity]`;
                newRow.querySelector('input[name="products[][price]"]').name =
                    `products[${currentRowCount}][price]`;

                productList.appendChild(newRow);
                updateRowNumbers(); // Panggil fungsi ini setelah baris baru ditambahkan
            });

            productList.addEventListener('change', function(e) {
                if (e.target.classList.contains('product-select')) {
                    const row = e.target.closest('.product-row');
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const name = selectedOption.value;

                    // Update hidden input for product name
                    row.querySelector('.product-name').value = name;
                    row.querySelector('.product-price').value = price;

                    const qtyInput = row.querySelector('.product-quantity');
                    if (qtyInput.value) {
                        const totalValue = parseFloat(price) * parseFloat(qtyInput.value);
                        row.querySelector('.total-price').textContent = 'Rp ' + totalValue.toLocaleString(
                            'id-ID');
                        updateGrandTotal();
                    }
                }
            });

            productList.addEventListener('input', function(e) {
                if (e.target.classList.contains('product-quantity')) {
                    const row = e.target.closest('.product-row');
                    const qty = parseFloat(e.target.value) || 0;
                    const price = parseFloat(row.querySelector('.product-price').value) || 0;
                    const totalValue = qty * price;
                    row.querySelector('.total-price').textContent = 'Rp ' + totalValue.toLocaleString(
                        'id-ID');
                    updateGrandTotal();
                }
            });

            productList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    e.target.closest('.product-row').remove();
                    updateRowNumbers(); // Panggil fungsi ini setelah baris dihapus
                    updateGrandTotal();
                }
            });

            function updateGrandTotal() {
                let total = 0;

                document.querySelectorAll('.total-price').forEach(el => {
                    // Hapus 'Rp ' dan spasi untuk mendapatkan nilai numerik
                    const value = el.textContent.replace('Rp ', '').replace(/\./g, '').replace(/,/g, '');
                    total += parseFloat(value) || 0;
                });

                document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

                // Pastikan elemen-elemen ini ada sebelum mengaksesnya
                const globalDiscountInput = document.getElementById('global-discount');
                if (globalDiscountInput) {
                    const discountPercent = parseFloat(globalDiscountInput.value) || 0;
                    const discountAmount = total * discountPercent / 100;

                    const discountAmountDisplay = document.getElementById('discount-amount');
                    if (discountAmountDisplay) {
                        discountAmountDisplay.textContent = 'Rp ' + discountAmount.toLocaleString('id-ID');
                    }

                    const finalTotalDisplay = document.getElementById('final-total');
                    if (finalTotalDisplay) {
                        const finalTotal = total - discountAmount;
                        finalTotalDisplay.textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
                    }
                }
            }

            // Panggil updateGrandTotal saat global-discount berubah (pastikan ID ini ada di HTML Anda)
            const globalDiscountInput = document.getElementById('global-discount');
            if (globalDiscountInput) {
                globalDiscountInput.addEventListener('input', updateGrandTotal);
            }

            // Panggil updateRowNumbers saat halaman pertama kali dimuat jika ada baris awal
            updateRowNumbers();

            // Tambahkan baris produk pertama secara otomatis saat halaman dimuat
            addProductButton.click(); // Simulasikan klik tombol tambah untuk baris pertama

        });
    </script>
@endsection