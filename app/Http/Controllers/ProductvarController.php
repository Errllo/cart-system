<?php

namespace App\Http\Controllers;

use App\Models\productvar;
use Illuminate\Http\Request;

class ProductvarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = productvar::with('product')->get();

        return response()->json([
            'message' => 'Product variants retrieved successfully',
            'data' => $variants
        ], 200); //status code 200 for OK

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $variant = productvar::create([
            'product_id' => $request->product_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'message' => 'Product variant created successfully',
            'data' => $variant
        ], 201); //status code 201 for Created
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $productvar = productvar::findOrFail($id);

        $productvar->update([
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return response()->json([
            'message' => 'Product variant has been updated.',
            'data' => $productvar
        ], 200); //status code 200 for OK
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = productvar::findOrFail($id);
        $variant->delete();

        return response()->json([
            'message' => 'Product variant has been deleted.'
        ], 200); //status code 200 for OK
    }
}
