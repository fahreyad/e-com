<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(
                Category::orderBy('serial', 'asc')
            )
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $color = match ($row->status->value) {
                        0 => 'text-red-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-indigo-600 ',
                        default => 'text-gray-600 '
                    };
                    return '<span class="px-2 py-1 rounded font-medium ' . $color . '">' .
                        $row->status->description . '</span>';
                })
                ->addColumn('active_status', function ($row) {
                    $color = match ($row->active_status->value) {
                        0 => 'text-red-600 ',
                        1 => 'text-green-600 ',
                        default => 'text-gray-600 '
                    };
                    return '<span class="px-2 py-1 rounded font-medium ' . $color . '">' .
                        $row->active_status->description . '</span>';
                })

                ->rawColumns(['status', 'active_status'])
                ->toJson();
        }
        return view('admin.category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'nullable|numeric',
            'active_status' => 'nullable|numeric',
            'home_page_position' => 'nullable|numeric',
            'serial' => 'nullable|numeric|unique:categories,serial',
        ]);

        if (empty($validated['active_status'])) {
            $validated['active_status'] = \App\Enums\CommonStatus::Inactive;
        }
     
        $validated['slug'] = Str::slug($validated['category_name']);

        return response()->reportTo(
            Category::create($validated),
            'Created successfully',
            route('admin.categories.index')
        );
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validate input
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'nullable|numeric',
            'active_status' => 'nullable|numeric',
            'home_page_position' => 'nullable|numeric',
            'serial' => 'nullable|numeric',
        ]);

        if (empty($validated['active_status'])) {
            $validated['active_status'] = \App\Enums\CommonStatus::Inactive;
        }

        if (!empty($validated['category_name'])) {
            $validated['slug'] = Str::slug($validated['category_name']);
        }

        if (empty($validated['status'])) {
            $validated['status'] = \App\Enums\CategoryStatus::No;
        }

        // Return response
        return response()->reportTo(
            $category->update($validated),
            'Updated successfully',
            route('admin.categories.index')
        );
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        try {
            return response()->reportTo(
                $category->delete(),
                'Deleted successfully',
                route('admin.categories.index')
            );
        } catch (QueryException $e) {
            // Check for foreign key constraint violation (MySQL error code 1451)
            if ($e->getCode() == 23000) {
                return response()->error(
                    'Cannot delete category: products are still assigned to it.',
                );
            }

            // General DB error fallback
            return response()->error(
                'Failed to delete category due to a database error.',
            );
        }
    }
}
