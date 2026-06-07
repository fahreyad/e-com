<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Gallery::get())->addIndexColumn()->toJson();
        }
        return view('admin.gallery.index');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'serial'        => 'nullable|integer',
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:5120', // if uploading an image
        ]);

        return response()->reportTo(
            Gallery::create($validated),
            'Created successfully',
            route('admin.gallery.index')
        );
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.index', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        // Validate input
        $validated = $request->validate([
            // 'serial'        => 'nullable|integer',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // if uploading an image           
        ]);
        // Return response
        return response()->reportTo(
            $gallery->update($validated),
            'Updated successfully',
            route('admin.gallery.index')
        );
    }


    public function destroy(Gallery $gallery)
    {
        return response()->report(
            $gallery->delete(),
            'Deleted successfully',
        );
    }
}
