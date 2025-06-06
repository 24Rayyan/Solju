@extends('layouts.app')

@section('menu')
    <div class="flex items-center space-x-4 text-sm text-gray-500">
        <i class="fas fa-home text-lg text-gray-400"></i>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-300 font-semibold">Manajemen Order</span>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-700 font-semibold">Upload bukti bayar</span>
    </div>
@endsection

@section('content')
    <div class="px-6 py-8">
        <h2 class="text-2xl font-semibold mb-6">Upload Pembayaran - Invoice #{{ $order->invoice_number }}</h2>

        <form>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Reseller</label>
                    <input type="text" value="{{ $order->customer_name }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100" disabled>
                </div>
                {{-- <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Reseller</label>
                <textarea rows="3" class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100" disabled>{{ $order->customer_address }}</textarea>
            </div> --}}
            </div>
            <div class="w-full mt-10 px-6 py-4" style="background-color:white; border-radius:20px;">
                <div class="mt-8">
                    <h3 class="text-lg font-medium mb-4">Produk</h3>

                    <table class="w-full border text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama Produk</th>
                                <th class="px-4 py-2">Jumlah</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderProducts as $index => $product)
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">
                                        <input type="text" value="{{ $product->name }}"
                                            class="w-full border border-gray-300 rounded-md px-2 py-1 bg-gray-100" disabled>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" value="{{ $product->quantity }}"
                                            class="w-full border border-gray-300 rounded-md px-2 py-1 bg-gray-100" disabled>
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="text" value="Rp {{ number_format($product->price, 0, ',', '.') }}"
                                            class="w-full border border-gray-300 rounded-md px-2 py-1 bg-gray-100" disabled>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <span class="block">Rp
                                            {{ number_format($product->price * $product->quantity, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right mt-4 font-semibold">
                        Total Bayar: Rp
                        {{ number_format($order->orderProducts->sum(fn($p) => $p->price * $p->quantity), 0, ',', '.') }}
                    </div>
                </div>
        </form>
    </div>

    </div>
    {{-- <hr class="my-6 border-gray-300"> --}}

    {{-- Form Upload --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('orders.upload.store', $order->id) }}" method="POST" enctype="multipart/form-data"
        class="w-full bg-white p-6 rounded-xl shadow-md space-y-6">
        @csrf

        {{-- Area Upload Drag & Drop --}}
        <div class="">
            <label class="block text-gray-700 font-semibold mb-10">Foto Bukti Bayar</label>
            {{-- Preview Gambar --}}
            <div id="preview-container" class="hidden flex justify-center">
                <img id="preview-image" class="border-2 border-gray-200 rounded-lg shadow-lg w-72 object-contain"
                    alt="Preview Gambar">
            </div>

            <div id="drop-zone"
                class="flex flex-col items-center justify-center border-2 border-dashed border-blue-400 rounded-lg p-6 cursor-pointer hover:border-blue-600 transition relative bg-blue-50"
                onclick="document.getElementById('payment_proof').click()"
                ondragover="event.preventDefault(); this.classList.add('border-blue-600', 'bg-blue-100')"
                ondragleave="event.preventDefault(); this.classList.remove('border-blue-600', 'bg-blue-100')"
                ondrop="handleDrop(event)">
                <div class="w-[40px] h-[40px] flex items-center justify-center bg-gray-200 rounded-full mb-5">
                    <i class="fa-solid fa-cloud-arrow-up text-[24px]"></i>
                </div>
                <p class="text-black-700 font-medium" style="font-size: 20px;"><span
                        style="color:#0764A7; font-size:20px;">Click to upload</span> or drag and drop</p>
                <p class="text-sm text-gray-500 mt-1" style="font-size:12px;">JPG, JPEG or PNG (max. 2mb)</p>
            </div>

            {{-- Hidden input --}}
            <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="sr-only"
                onchange="previewImage(event)" required>

            <p id="file-name" class="mt-2 text-sm text-gray-500 truncate"></p>

            @error('payment_proof')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-center gap-4 mt-4">
            <button type="submit"
                class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 shadow">
                Upload
            </button>
            <a href="{{ route('orders.index') }}"
                class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-gray-300 transition duration-300 shadow">
                Kembali
            </a>
        </div>
    </form>

    {{-- Script Preview dan Drag & Drop --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const fileNameDisplay = document.getElementById('file-name');
            const dropZone = document.getElementById('drop-zone');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    dropZone.classList.add('hidden'); // Sembunyikan drop-zone setelah gambar tampil
                };
                reader.readAsDataURL(input.files[0]);
                fileNameDisplay.textContent = input.files[0].name;
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            const dropZone = document.getElementById('drop-zone');
            dropZone.classList.remove('border-blue-600', 'bg-blue-100');

            const fileInput = document.getElementById('payment_proof');
            if (event.dataTransfer.files.length > 0) {
                fileInput.files = event.dataTransfer.files;
                previewImage({
                    target: fileInput
                });
            }
        }
    </script>
@endsection
