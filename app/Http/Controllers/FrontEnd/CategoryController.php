<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $selectedWeights = $request->input('weights', []);

        // Base product query
        $products = Product::where('active_status', \App\Enums\CommonStatus::Active())
            ->with('productVariations')
            ->where('category_id', $category->id)
            ->when($priceMin, fn($q) => $q->where('sale_price', '>=', $priceMin))
            ->when($priceMax, fn($q) => $q->where('sale_price', '<=', $priceMax))
            ->when(!empty($selectedWeights), function ($q) use ($selectedWeights) {
                $q->where(function ($q) use ($selectedWeights) {
                    $q->whereIn('value', $selectedWeights)
                        ->orWhereHas('productVariations', function ($q2) use ($selectedWeights) {
                            $q2->whereIn('variation_value', $selectedWeights);
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get all unique weights from Product and ProductVariation
        $fromProducts = Product::where('category_id', $category->id)->pluck('value');
        $fromVariations = ProductVariation::whereHas('product', function ($q) use ($category) {
            $q->where('category_id', $category->id);
        })->pluck('variation_value');

        $allWeights = $fromProducts
            ->merge($fromVariations)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('front-end.category.index', compact('products', 'category', 'allWeights'));
    }
}
