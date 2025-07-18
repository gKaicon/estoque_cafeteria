<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::orderBy('name')->get();
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        $product = Product::create($data);
        return response()->json($product, 201);
    }
    public function show(Product $product)
    {
        return $product;
    }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'sale_price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);
        $product->update($data);
        return response()->json($product);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
