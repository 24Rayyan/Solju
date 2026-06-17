<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class keuanganController extends Controller
{
    public function index()
    {
        $data = Order::with('products')
            ->whereNotNull('payment_proof') // hanya yang sudah bayar
            ->get()
            ->map(function ($order) {
                $totalProduk = $order->products->sum('quantity');
                $totalHarga = $order->products->sum(function ($product) {
                    return $product->quantity * $product->price;
                });

                return [
                    'invoice_number' => $order->invoice_number,
                    'nama_reseller' => $order->customer_name,
                    'total_produk' => $totalProduk,
                    'total_harga' => $totalHarga,
                ];
            });

        return view('pages.orders.keuangan', compact('data'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $orders = Order::with('products')
            ->whereNotNull('payment_proof')
            ->when($search, function ($query, $search) {
                // Menggunakan LOWER() agar pencarian di SQLite tidak sensitif huruf besar/kecil (case-insensitive)
                $lowerSearch = strtolower($search);
                return $query->whereRaw('LOWER(customer_name) LIKE ?', ["%{$lowerSearch}%"]);
            })
            ->paginate(10);

        $data = $orders->map(function ($order) {
            $totalProduk = $order->products->sum('quantity');
            $totalHarga = $order->products->sum(fn($p) => $p->quantity * $p->price);

            return [
                'invoice_number' => $order->invoice_number,
                'nama_reseller' => $order->customer_name,
                'total_produk' => $totalProduk,
                'total_harga' => $totalHarga,
            ];
        });

        return view('pages.orders.keuangan', compact('data', 'orders'));
    }
}