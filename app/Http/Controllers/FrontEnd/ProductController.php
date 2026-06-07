<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('active_status', \App\Enums\CommonStatus::Active())->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::where('active_status', \App\Enums\CommonStatus::Active())->get();
        return view('front-end.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $relatedProducts = null;
        if (isset($product->category_id)) {
            $relatedProducts = Product::where('active_status', \App\Enums\CommonStatus::Active())->where('id', '!=', $product->id)->where('category_id', $product->category_id)->get();
        }

        return view('front-end.products.show', compact('product', 'relatedProducts'));
    }
}
