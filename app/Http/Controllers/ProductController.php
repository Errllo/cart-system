<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = product::all();

        return response()->json([
            'message' => 'Product has been retrieved.',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = product::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Product has been created.',
            'data' => $product
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $product = product::findOrFail($id);
        $product->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Product has been updated.',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product has been deleted.'
        ], 200);
    }
}
