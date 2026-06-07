<?php

namespace App\Http\Livewire;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Livewire\Component;

class ProductFilter extends Component
{
    // ✅ These must be public!
    public $categories = [];
    public $selectedCategories = [];

    public $priceMin;
    public $priceMax;

    public $weights = ['250gm', '500gm', '1kg', '2kg', '5kg+'];
    public $selectedWeights = [];

    public function render()
    {
        $products = Product::query();

        // Category filter
        if (!empty($this->selectedCategories)) {
            $products->whereIn('category_id', $this->selectedCategories);
        }

        // Weight filter via variations
        if (!empty($this->selectedWeights)) {
            $products->whereHas('productVariations', function ($query) {
                $query->whereIn('variation_value', $this->selectedWeights);
            });
        }

        // ✅ Price filter from both product and its variations
        if ($this->priceMin || $this->priceMax) {
            $products->where(function ($query) {
                $query->where(function ($q) {
                    if ($this->priceMin) {
                        $q->where('sale_price', '>=', $this->priceMin);
                    }
                    if ($this->priceMax) {
                        $q->where('sale_price', '<=', $this->priceMax);
                    }
                });

                $query->orWhereHas('productVariations', function ($q) {
                    if ($this->priceMin) {
                        $q->where('sale_price', '>=', $this->priceMin);
                    }
                    if ($this->priceMax) {
                        $q->where('sale_price', '<=', $this->priceMax);
                    }
                });
            });
        }

        return view('livewire.product-filter', [
            'products' => $products->orderBy('created_at', 'desc')->paginate(15),
            'allCategories' => Category::all(),
        ]);
    }
}
