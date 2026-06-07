<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Product::with(['category', 'productVariations'])->orderBy('created_at', 'desc'))
                ->addIndexColumn()
                ->addColumn('active_status', function ($row) {
                    $color = match ($row->active_status->value) {
                        0 => 'text-red-600 ',
                        1 => 'text-green-600 ',
                        default => 'text-gray-600 '
                    };
                    return '<span class="px-2 py-1 rounded font-medium ' . $color . '">' .
                        $row->active_status->description . '</span>';
                })

                ->rawColumns(['active_status'])
                ->toJson();
        }
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        $variations = Variation::all();
        return view('admin.product.create', compact('categories', 'variations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'value' => 'nullable|string|max:255',
            'active_status' => 'nullable|numeric',
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:regular_price',
            'is_variation' => 'nullable|integer|min:0',
            'is_best_sale' => 'nullable|integer|min:0',
            'is_hot_sale' => 'nullable|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'gallery_image' => 'nullable|array',
            'gallery_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'variations' => 'nullable|array',
            'variations.*.id' => 'required_with:variations|exists:variations,id',
            'variations.*.variation_value' => 'required_with:variations|string',
            'variations.*.regular_price' => 'required_with:variations|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
        ]);


        $isVariation = $validated['is_variation'] ?? null;
        $isBestSale = $validated['is_best_sale'] ?? null;
        $isHotSale = $validated['is_hot_sale'] ?? null;

        if (!empty($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . rand(1000, 9999));
        }

        try {
            DB::beginTransaction();
            // Create and fill product
            $product = new Product();
            $product->name = $validated['name'];
            $product->slug = $validated['slug'];
            $product->image = $validated['image'];
            $product->gallery_image = $validated['gallery_image'] ?? null;
            $product->category_id = $validated['category_id'] ?? null;
            $product->short_description = $validated['short_description'] ?? null;
            $product->description = $validated['description'] ?? null;
            $product->is_variation = $isVariation;
            $product->is_best_sale = $isBestSale;
            $product->is_hot_sale = $isHotSale;
            $product->active_status = $validated['active_status'] ?? \App\Enums\CommonStatus::Inactive;

            if (!empty($isVariation) && $isVariation == \App\Enums\ProductStatus::Variation) {
                $product->value = null;
                $product->regular_price = 0;
                $product->sale_price = 0;
            } else {
                $product->value = $validated['value'];
                $product->regular_price = $validated['regular_price'];
                $product->sale_price = $validated['sale_price'] ?? null;
            }

            // 🔥 Save the product before using $product->id
            $product->save();

            // ✅ Now create variations
            if (!empty($isVariation) && is_array($request->input('variations'))) {
                foreach ($request->input('variations') as $varData) {
                    $product->productVariations()->create([
                        'variation_id' => $varData['id'],
                        'variation_value' => $varData['variation_value'],
                        'regular_price' => $varData['regular_price'],
                        'sale_price' => $varData['sale_price'] ?? null,
                    ]);
                }
            }
            DB::commit();

            return response()->reportTo(
                true,
                'Created successfully',
                route('admin.product.index')
            );
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->error(
                'Something went wrong! Try again.',
            );
        }
    }

    public function edit(Product $product)
    {
        if ($product->is_variation == \App\Enums\ProductStatus::Variation) {
            $product->load('productVariations'); // correct way
        }

        $categories = Category::all();
        $variations = Variation::all();

        return view('admin.product.edit', compact('product', 'categories', 'variations'));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'value' => 'nullable|string|max:255',
            'active_status' => 'nullable|numeric',
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:regular_price',
            'is_variation' => 'nullable|integer|min:0',
            'is_best_sale' => 'nullable|integer|min:0',
            'is_hot_sale' => 'nullable|integer|min:0',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'gallery_image' => 'nullable|array',
            'gallery_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'variations' => 'nullable|array',
            'variations.*.id' => 'required_with:variations|exists:variations,id',
            'variations.*.variation_value' => 'required_with:variations|string',
            'variations.*.regular_price' => 'required_with:variations|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
        ]);

        $isVariation = $validated['is_variation'] ?? null;

        try {
            DB::beginTransaction();

            $product->name = $validated['name'];
            $product->slug = Str::slug($validated['name']) . '-' . $product->id;
            if (isset($validated['image'])) {
                $product->image = $validated['image'];
            }
            if (isset($validated['gallery_image'])) {
                $product->gallery_image = $validated['gallery_image'];
            }
            $product->category_id = $validated['category_id'] ?? null;
            $product->is_variation = $validated['is_variation'] ?? null;
            $product->is_best_sale = $validated['is_best_sale'] ?? null;
            $product->is_hot_sale = $validated['is_hot_sale'] ?? null;
            $product->short_description = $validated['short_description'] ?? null;
            $product->description = $validated['description'] ?? null;
            $product->active_status = $validated['active_status'] ?? \App\Enums\CommonStatus::Inactive;

            // Handle variation or single pricing
            if (!empty($isVariation) && $isVariation == \App\Enums\ProductStatus::Variation) {
                $product->value = null;
                $product->regular_price = 0;
                $product->sale_price = 0;
            } else {
                $product->value = $validated['value'];
                $product->regular_price = $validated['regular_price'];
                $product->sale_price = $validated['sale_price'] ?? null;
            }

            $product->save();

            // Sync Variations
            if (!empty($isVariation) && is_array($request->input('variations'))) {
                // Remove all old variations
                $product->productVariations()->delete();

                // Add new variations
                foreach ($request->input('variations') as $varData) {
                    $product->productVariations()->create([
                        'variation_id' => $varData['id'],
                        'variation_value' => $varData['variation_value'],
                        'regular_price' => $varData['regular_price'],
                        'sale_price' => $varData['sale_price'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->reportTo(
                true,
                'Product updated successfully!',
                route('admin.product.index')
            );
        } catch (\Exception $e) {

            DB::rollBack();
            report($e);
            return response()->report(
                false,
                'Update failed. Please try again.'
            );
        }
    }


    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            if ($product->is_variation == \App\Enums\ProductStatus::Variation) {
                $variationsProducts = $product->productVariations()->get();
                foreach ($variationsProducts as $variationsProduct) {
                    $variationsProduct->delete();
                }
            }
            DB::commit();
            return response()->report(
                $product->delete(),
                'Deleted successfully',
            );
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->report(
                false,
                'Something went wrong! Try again.',
            );
        }
    }
}
