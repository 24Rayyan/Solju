<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 5);

        $orders = Order::when($search, function ($query, $search) {
            // Menggunakan LOWER() agar pencarian nama di SQLite bersifat case-insensitive
            $lowerSearch = strtolower($search);
            return $query->whereRaw('LOWER(customer_name) LIKE ?', ["%{$lowerSearch}%"]);
        })
        ->orderBy('updated_at', 'desc')
        ->paginate($perPage)
        ->appends(['search' => $search, 'perPage' => $perPage]);

        return view('pages.orders.index', compact('orders', 'search', 'perPage'));
    }

    public function create()
    {
         $products = Product::all(); // Ambil semua produk
        return view('pages.orders.create', compact('products'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'invoice_number' => 'INV-' . time(),
        ]);

        foreach ($request->products as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat!');
    }

    public function show(Order $order)
    {
        $order->load('products');
        return view('pages.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('pages.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
        ]);

        $order->orderProducts()->delete();

        foreach ($request->products as $productData) {
            $order->orderProducts()->create([
                'name' => $productData['name'],
                'quantity' => $productData['quantity'],
                'price' => $productData['price'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Data telah di updata.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Data telah dihapus.');
    }

    public function downloadInvoice(Order $order)
    {
        $pdf = Pdf::loadView('pages.invoices.download', compact('order'));
        return $pdf->download('Invoice'.$order->id.'.pdf');
    }

    // Keuangan
    public function showUpload($id)
    {
        $order = Order::with('orderProducts')->findOrFail($id);
        $total = 0;
        foreach ($order->orderProducts as $product) {
            $total += $product->quantity * $product->price;
        }

        return view('pages.orders.upload_bukti', compact('order', 'total'));
    }

    public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::with('orderProducts')->findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('bukti', 'public');
            $order->payment_proof = $path;
            $order->save();
        }

        return redirect()->route('orders.index')
        ->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function showBukti(Order $order)
    {
        return view('pages.orders.lihat_bukti', compact('order'));
    }

    public function payment(Order $order)
    {
        $total = 0;
        foreach ($order->orderProducts as $product) {
            $total += $product->quantity * $product->price;
        }

        return view('pages.orders.upload_bukti', compact('order', 'total'));
    }
}