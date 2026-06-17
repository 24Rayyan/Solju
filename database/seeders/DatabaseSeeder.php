<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT MASTER DATA PRODUK SOLJU
        $products = [
            ['product_code' => 'SLJ-001', 'name' => 'Solju Halal - Sparkling Peach', 'price' => 45000],
            ['product_code' => 'SLJ-002', 'name' => 'Solju Halal - Sweet Lychee', 'price' => 45000],
            ['product_code' => 'SLJ-003', 'name' => 'Solju Halal - Creamy Yogurt', 'price' => 48000],
            ['product_code' => 'SLJ-004', 'name' => 'Solju Halal - Fresh Strawberry', 'price' => 45000],
            ['product_code' => 'SLJ-005', 'name' => 'Solju Halal - Green Apple', 'price' => 45000],
        ];

        $insertedProducts = [];
        foreach ($products as $productData) {
            $insertedProducts[] = Product::create($productData);
        }

        // 2. DATA DUMMY KLIEN / RESELLER ASLI (Variasi Nama & Kota)
        $customers = [
            ['name' => 'Rayyan Pratama', 'address' => 'Jl. Buah Batu No. 12, Bandung'],
            ['name' => 'Budi Santoso', 'address' => 'Jl. Kemang Raya No. 45, Jakarta'],
            ['name' => 'Siti Rahma', 'address' => 'Jl. Malioboro No. 8, Yogyakarta'],
            ['name' => 'Amiruddin', 'address' => 'Jl. Dago Asri No. 102, Bandung'],
            ['name' => 'Linda Wijaya', 'address' => 'Jl. Gubeng Kertajaya No. 14, Surabaya'],
            ['name' => 'Agus Setiawan', 'address' => 'Jl. Simpang Lima No. 3, Semarang'],
            ['name' => 'Hendra Wijaya', 'address' => 'Jl. Kopo Indah No. 88, Bandung'],
            ['name' => 'Rina Marlina', 'address' => 'Jl. Antapani No. 17, Bandung'],
            ['name' => 'Dewi Lestari', 'address' => 'Jl. Sudirman No. 210, Jakarta'],
            ['name' => 'Fahmi Idris', 'address' => 'Jl. Kaliurang KM 5, Yogyakarta'],
        ];

        // 3. GENERATE TRANSAKSI SELAMA 1 TAHUN KEBELAKANG
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subYear(); // Mundur 1 tahun

        // Looping per hari dari 1 tahun lalu sampai hari ini
        while ($startDate->lessThanOrEqualTo($endDate)) {
            
            // Logika Tren: Kalau Weekend (Jumat-Minggu) orderan lebih banyak (3-7 order/hari)
            // Kalau Weekday (Senin-Kamis) orderan standar (1-3 order/hari)
            $isWeekend = $startDate->isWeekend() || $startDate->isFriday();
            $orderCount = $isWeekend ? rand(3, 7) : rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                
                // Acak jam transaksi biar natural
                $orderDate = $startDate->copy()->setHour(rand(9, 21))->setMinute(rand(0, 59));
                $buyer = $customers[array_rand($customers)];

                // 90% Transaksi diset Lunas (ada bukti), 10% Belum Lunas
                $isPaid = rand(1, 10) <= 9;

                $order = Order::create([
                    'customer_name'    => $buyer['name'],
                    'customer_address' => $buyer['address'],
                    'payment_proof'    => $isPaid ? 'bukti/dummy_proof.png' : null,
                    'created_at'       => $orderDate,
                    'updated_at'       => $orderDate,
                ]);

                // Berapa varian rasa yang dibeli dalam 1 invoice ini (1 sampai 4 rasa)
                $flavorCount = rand(1, 4);
                
                // Berikan bobot lebih tinggi untuk Peach (index 0) dan Lychee (index 1) agar jadi top product
                $selectedProducts = collect($insertedProducts)->shuffle()->take($flavorCount);

                foreach ($selectedProducts as $product) {
                    // Jumlah botol per rasa (diacak dari retail kecil sampai partai reseller)
                    $quantity = rand(1, 5) === 5 ? rand(12, 24) : rand(2, 8);

                    OrderProduct::create([
                        'order_id'   => $order->id,
                        'name'       => $product->name,
                        'quantity'   => $quantity,
                        'price'      => $product->price,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);
                }
            }

            // Maju ke hari berikutnya
            $startDate->addDay();
        }
    }
}