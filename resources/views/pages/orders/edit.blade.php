@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500">
        <img src="{{ asset('resources/asset/home.png') }}" alt="dashboard" style="width: 24px; height: 24px;">
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-300 font-semibold" style="font-size: 14px;">Manajemen Order</span>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold">Edit Order</span>
    </div>
@endsection

@section('content')
    <div class="px-6 py-8">



        <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Edit Order</h2>
                <button type="submit" class="bg-black text-white px-6 py-2 rounded-md"><i class="fa-solid fa-floppy-disk"
                        style="margin-right: 10px"></i>Update Order</button>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer<span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ $order->customer_name }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Customer<span class="text-red-500">*</span></label>
                    <textarea name="customer_address" rows="4"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        required>{{ $order->customer_address }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-md mt-6">
                <h3 class="text-lg font-medium mb-4">Produk<span class="text-red-500">*</span></h3>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Produk</th>
                                <th class="px-4 py-2">Jumlah</th>
                                <th class="px-4 py-2">Harga Satuan</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="product-list-edit">
                            @foreach ($order->orderProducts as $index => $product)
                                <tr class="product-row border-b border-gray-200">
                                    <td class="px-4 py-2 counter">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">
                                        <input type="hidden" name="products[{{ $index }}][id]"
                                            value="{{ $product->id }}">
                                        {{-- Mengubah dari input text menjadi select --}}
                                        <select name="products[{{ $index }}][name]"
                                            class="product-select w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                            <option value="">Pilih produk</option>
                                            {{-- Contoh opsi produk. Pastikan Anda memiliki variabel $allProducts yang berisi daftar produk dari controller Anda. --}}
                                            {{-- Jika tidak ada, hardcode dulu atau kirim dari controller --}}
                                            <option value="Solju Grape" data-price="50000"
                                                @if ($product->name == 'Solju Grape') selected @endif>Solju Grape</option>
                                            <option value="Solju Strawberry" data-price="60000"
                                                @if ($product->name == 'Solju Strawberry') selected @endif>Solju Strawberry</option>
                                            <option value="Solju Leci" data-price="40000"
                                                @if ($product->name == 'Solju Leci') selected @endif>Solju Leci</option>
                                            <option value="Solju Soda" data-price="60000"
                                                @if ($product->name == 'Solju Soda') selected @endif>Solju Soda</option>
                                            <option value="Solju Apel" data-price="60000"
                                                @if ($product->name == 'Solju Apel') selected @endif>Solju Apel</option>
                                            <option value="Solju Original" data-price="50000"
                                                @if ($product->name == 'Solju Original') selected @endif>Solju Original</option>
                                            {{-- Uncomment dan sesuaikan ini jika Anda mengambil data produk dari database --}}
                                            {{-- @foreach ($allProducts as $p)
                                                <option value="{{ $p->name }}" data-price="{{ $p->price }}" @if ($product->name == $p->name) selected @endif>{{ $p->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        {{-- Input hidden untuk nama produk yang dipilih dari select --}}
                                        <input type="hidden" class="product-name"
                                            name="products[{{ $index }}][name_value]" value="{{ $product->name }}">
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" name="products[{{ $index }}][quantity]"
                                            class="product-quantity w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            value="{{ $product->quantity }}" required min="1">
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" name="products[{{ $index }}][price]"
                                            class="product-price w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed"
                                            value="{{ $product->price }}" step="0.01" readonly>
                                    </td>
                                    <td class="px-4 py-3 w-36 whitespace-nowrap">
                                        <span class="total-price block text-right">Rp
                                            {{ number_format($product->quantity * $product->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button"
                                            class="remove-product px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-4">
                    <strong>Total Bayar:</strong> <span id="grand-total-edit" class="ml-2">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-product-edit"
                        class="w-full bg-black text-white px-4 py-2 rounded-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus" style="margin-right:16px"></i><span style="font-size:16px;">Tambah
                            Produk</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Template untuk baris produk baru --}}
    <template id="product-row-template-edit">
        <tr class="product-row border-b border-gray-200">
            <td class="px-4 py-2 counter"></td> {{-- Nomor akan diisi JS --}}
            <td class="px-4 py-2">
                <select class="product-select w-full px-2 py-1 border border-gray-300 rounded" required>
                    <option value="">Pilih produk</option>
                    {{-- Contoh opsi produk. Sesuaikan dengan data produk Anda. --}}
                    <option value="Solju Grape" data-price="50000">Solju Grape</option>
                    <option value="Solju Strawberry" data-price="60000">Solju Strawberry</option>
                    <option value="Solju Leci" data-price="40000">Solju Leci</option>
                    <option value="Solju Soda" data-price="60000">Solju Soda</option>
                    <option value="Solju Apel" data-price="60000">Solju Apel</option>
                    <option value="Solju Original" data-price="50000">Solju Original</option>
                    {{-- Uncomment dan sesuaikan ini jika Anda mengambil data produk dari database --}}
                    {{-- @foreach ($allProducts as $product)
                    <option value="{{ $product->name }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach --}}
                </select>
                <input type="hidden" class="product-name"> {{-- Hidden input for name --}}
                <input type="hidden" name="products[][id]" value=""> {{-- ID produk baru akan kosong --}}
            </td>
            <td class="px-4 py-3">
                <input type="number" name="products[][quantity]"
                    class="product-quantity w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Jumlah" required min="1">
            </td>
            <td class="px-4 py-3">
                <input type="number" name="products[][price]"
                    class="product-price w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
                    readonly>
            </td>
            <td class="px-4 py-3 w-36 whitespace-nowrap">
                <span class="total-price block text-right">Rp 0</span>
            </td>
            <td class="px-4 py-3">
                <button type="button"
                    class="remove-product px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
            </td>
        </tr>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productList = document.getElementById('product-list-edit');
            const addProductButton = document.getElementById('add-product-edit');
            const template = document.getElementById('product-row-template-edit').content;
            const grandTotalDisplay = document.getElementById('grand-total-edit');

            // Inisialisasi productIndex dengan jumlah produk yang sudah ada
            // Ini akan memastikan indeks dimulai setelah produk yang sudah ada
            let productIndex = productList.children.length;

            // Fungsi untuk mengupdate nomor urut pada kolom 'No'
            function updateRowNumbers() {
                const rows = productList.querySelectorAll('.product-row');
                rows.forEach((row, index) => {
                    row.querySelector('.counter').textContent = index + 1;
                });
            }

            // Panggil saat halaman dimuat untuk nomor urut awal
            updateRowNumbers();


            addProductButton.addEventListener('click', function() {
                const newRow = document.importNode(template, true);

                // Atur nama input agar sesuai dengan array Laravel
                // Gunakan productIndex untuk membuat nama input unik
                newRow.querySelector('.product-select').name = `products[${productIndex}][name]`;
                newRow.querySelector('input.product-name').name =
                `products[${productIndex}][name_value]`; // Hidden input for name value
                newRow.querySelector('input[name="products[][id]"]').name = `products[${productIndex}][id]`;
                newRow.querySelector('input[name="products[][quantity]"]').name =
                    `products[${productIndex}][quantity]`;
                newRow.querySelector('input[name="products[][price]"]').name =
                    `products[${productIndex}][price]`;

                // Tambahkan baris baru ke tbody
                productList.appendChild(newRow);

                // Update nomor urut
                updateRowNumbers();

                // Tingkatkan indeks untuk baris berikutnya
                productIndex++;
            });

            // Event listener untuk perubahan pada select produk dan kuantitas
            productList.addEventListener('change', function(e) {
                if (e.target.classList.contains('product-select')) {
                    const row = e.target.closest('.product-row');
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                    const name = selectedOption.value;

                    row.querySelector('.product-name').value = name; // Update hidden name input
                    row.querySelector('.product-price').value = price;

                    const qtyInput = row.querySelector('.product-quantity');
                    const qty = parseFloat(qtyInput.value) || 0;
                    const totalValue = price * qty;

                    row.querySelector('.total-price').textContent = 'Rp ' + totalValue.toLocaleString(
                        'id-ID');
                    updateGrandTotal();
                }
            });

            productList.addEventListener('input', function(e) {
                if (e.target.classList.contains('product-quantity') || e.target.classList.contains(
                        'product-price')) {
                    const row = e.target.closest('.product-row');
                    const qty = parseFloat(row.querySelector('.product-quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.product-price').value) || 0;
                    const totalValue = qty * price;

                    row.querySelector('.total-price').textContent = 'Rp ' + totalValue.toLocaleString(
                        'id-ID');
                    updateGrandTotal();
                }
            });

            // Event listener untuk tombol "Hapus"
            productList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-product')) {
                    e.target.closest('.product-row').remove();
                    updateRowNumbers(); // Update nomor urut setelah penghapusan
                    updateGrandTotal();
                }
            });

            // Fungsi untuk mengupdate total keseluruhan
            function updateGrandTotal() {
                let total = 0;

                document.querySelectorAll('#product-list-edit .total-price').forEach(el => {
                    const value = el.textContent.replace(/[^\d]/g, ''); // Hapus semua karakter non-digit
                    total += parseFloat(value) || 0;
                });

                grandTotalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

                // Jika ada logika diskon global, tambahkan di sini
                // Contoh:
                // const discountInput = document.getElementById('global-discount');
                // if (discountInput) {
                //     const discountPercent = parseFloat(discountInput.value) || 0;
                //     const discountAmount = total * discountPercent / 100;
                //     document.getElementById('discount-amount').textContent = 'Rp ' + discountAmount.toLocaleString('id-ID');
                //     const finalTotal = total - discountAmount;
                //     document.getElementById('final-total').textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
                // }
            }

            // Panggil updateGrandTotal saat halaman dimuat
            updateGrandTotal();

            // Tambahkan event listener untuk input diskon jika ada (jika Anda ingin diskon dinamis)
            // const globalDiscountInput = document.getElementById('global-discount');
            // if (globalDiscountInput) {
            //     globalDiscountInput.addEventListener('input', updateGrandTotal);
            // }
        });
    </script>
@endsection
