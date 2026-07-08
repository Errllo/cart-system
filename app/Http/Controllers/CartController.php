<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\productvar;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = cart::with('variant.product')->get();

        $totalPrice = 0;
        $formattedItems = [];

        foreach ($cart as $item) {
            if (!$item->variant) continue;

            $subtotal = $item->variant->price * $item->quantity;
            $totalPrice += $subtotal;

            $formattedItems[] = [
                'id' => $item->id,
                'product_name' => $item->variant->product->name,
                'variant_price' => $item->variant->price,
                'quantity' => $item->quantity,
                'subtotal' => $subtotal,
            ];
        }

        return response()->json([
            'message' => 'Cart items retrieved successfully',
            'total_items' => count($formattedItems),
            'total_price' => $totalPrice,
            'carts' => $formattedItems
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'productvar_id' => 'required|exists:productvars,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = productvar::find($request->productvar_id);
        $cartItem = cart::where('productvar_id', $request->productvar_id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($variant->stock < $newQuantity) {
                return response()->json([
                    'message' => 'Insufficient stock for request.',
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            if ($variant->stock < $request->quantity) {
                return response()->json([
                    'message' => 'Insufficient stock for request.',
                ], 400);
            }

            $cartItem = cart::create([
                'productvar_id' => $request->productvar_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Item added to cart.',
            'cart_item' => $cartItem
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = cart::findOrFail($id);
        $variant = productvar::findOrFail($cartItem->productvar_id);

        if ($variant->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock for request.',
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'message' => 'Cart item updated.',
            'cart_item' => $cartItem
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = cart::findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'message' => 'Cart item removed.',
        ], 200);
    }
}
