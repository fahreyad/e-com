<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'page_link' => 'nullable|string',
        ]);

        return response()->reportTo(
            Slider::create($validated),
            'Created successfully',
            route('admin.slider.index')
        );
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        // Validate input
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'page_link' => 'nullable|string',
        ]);

        // Return response
        return response()->reportTo(
            $slider->update($validated),
            'Updated successfully',
            route('admin.slider.index')
        );
    }


    public function destroy(Slider $slider)
    {
        return response()->reportTo(
            $slider->delete(),
            'Deleted successfully',
            route('admin.slider.index')
        );
    }
}
