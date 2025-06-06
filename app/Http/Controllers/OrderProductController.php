<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class OrderProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.produk.produk', compact('products'));
    }

    public function create()
    {
        return view('pages.produk.create_produk');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        Product::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.produk.edit_produk', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());

        return redirect()->route('produk.produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('produk.produk')->with('success', 'Produk berhasil dihapus.');
    }
}
