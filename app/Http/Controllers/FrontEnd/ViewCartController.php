<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;

class ViewCartController extends Controller
{
    public function index()
    {

        $bestSaleProducts = Product::where('active_status', \App\Enums\CommonStatus::Active())
            ->where('is_best_sale', \App\Enums\ProductStatus::BestSale()->value)
            ->whereNull('is_variation')
            ->latest() // same as orderBy('created_at', 'desc')
            ->take(20)
            ->get();
        $cartItems = session()->get('cart', []);
        return view('front-end.cart.index', compact('cartItems', 'bestSaleProducts'));
    }
}
