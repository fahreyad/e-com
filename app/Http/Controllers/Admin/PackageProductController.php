<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PackageProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(PackageProduct::orderBy('created_at', 'desc'))
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.package-product.index');
    }

    public function create()
    {
        return view('admin.package-product.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'value' => 'required|string|max:255',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:regular_price',
        ]);

        if (!empty($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . rand(1000, 9999));
        }
        return response()->reportTo(
            PackageProduct::create($validated),
            'Created successfully',
            route('admin.package-product.index')
        );
    }

    public function edit(PackageProduct $packageProduct)
    {
        return view('admin.package-product.edit', compact('packageProduct'));
    }


    public function update(Request $request, PackageProduct $packageProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'value' => 'required|string|max:255',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:regular_price',
        ]);

        if (!empty($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name'] . '-' . rand(1000, 9999));
        }
        // Return response
        return response()->reportTo(
            $packageProduct->update($validated),
            'Updated successfully',
            route('admin.package-product.index')
        );
    }


    public function destroy(PackageProduct $packageProduct)
    {
        

        try {
            return response()->report(
                $packageProduct->delete(),
                'Deleted successfully',
            );
        } catch (\Illuminate\Database\QueryException $e) {
            // Check if it's a foreign key constraint error
            if ($e->getCode() == "23000") {
                return response()->error(
                    'Cannot delete: this product is linked with corporate orders.',
                );
            }
            return response()->error(
                'Something went wrong. Please try again.!',
            );
        } catch (\Exception $e) {
            return response()->error(
                $e->getMessage(),
            );
        }
    }
}
