<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OutletSlider;
use Illuminate\Http\Request;

class OutletSliderController extends Controller
{
    public function index()
    {
        $outletSliders = OutletSlider::orderBy('created_at', 'desc')->get();
        return view('admin.outlet-slider.index', compact('outletSliders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'page_link' => 'nullable|string',
        ]);

        return response()->reportTo(
            OutletSlider::create($validated),
            'Created successfully',
            route('admin.outlet-slider.index')
        );
    }

    public function edit(OutletSlider $outletSlider)
    {
        return view('admin.outlet-slider.edit', compact('outletSlider'));
    }

    public function update(Request $request, OutletSlider $outletSlider)
    {
        // Validate input
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'page_link' => 'nullable|string',
        ]);

        // Return response
        return response()->reportTo(
            $outletSlider->update($validated),
            'Updated successfully',
            route('admin.outlet-slider.index')
        );
    }


    public function destroy(OutletSlider $outletSlider)
    {
        return response()->reportTo(
            $outletSlider->delete(),
            'Deleted successfully',
            route('admin.outlet-slider.index')
        );
    }
}
