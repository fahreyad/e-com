<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'status' => 'required|numeric',
            'product_variation_id' => 'nullable|exists:product_variations,id',
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
        ]);

        $id = $validated['product_id'];
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $price = 0;
        $value = null;
        if (!empty($validated['product_variation_id'])) {
            $productVariation = $product->productVariations()->findOrFail($validated['product_variation_id']);
            $value = $productVariation->variation_value;
            $price =  $productVariation['sale_price'] ?? $productVariation['regular_price'];
        } else {
            $value = $product->value;
            $price =  $product->sale_price ?? $product->regular_price;
        }


        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += (int) $validated['quantity'];
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'image' => $product->image,
                // 'price' => $product->sale_price ?? $product->regular_price,
                'price' => $price,
                'value' => $value,
                'quantity' => (int) $validated['quantity']
            ];
        }

        session()->put('cart', $cart);

        if ($validated['status'] == \App\Enums\ProductAddCartStatus::BuyNow) {

            return redirect()->route('checkout.index')->with('success', 'Product added to cart!');
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $action = $request->action;

        if (isset($cart[$id])) {
            if ($action === 'increase') {
                $cart[$id]['quantity'] += 1;
            } elseif ($action === 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            }

            session()->put('cart', $cart);

            $newQuantity = $cart[$id]['quantity'];
            $newTotal = $cart[$id]['price'] * $newQuantity;
            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            return response()->json([
                'quantity' => $newQuantity,
                'total' => number_format($newTotal, 2),
                'subtotal' => number_format($subtotal, 2)
            ]);
        }

        return response()->json(['error' => 'Invalid item'], 400);
    }



    public function productRemoveFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove the item
            session()->put('cart', $cart); // Save updated cart
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function productDeleteFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove the item
            session()->put('cart', $cart); // Save updated cart
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }


    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Clear Cart Successfully!');
    }
}
