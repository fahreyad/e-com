<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Variation;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(Variation::orderBy('created_at', 'asc'))
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.variation.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);
        return response()->report(
            Variation::create($validated),
            'Created successfully',
        );
    }



    public function edit(Variation $variation)
    {
        return view('admin.variation.edit', compact('variation'));
    }

    public function update(Request $request, Variation $variation)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        // Return response
        return response()->reportTo(
            $variation->update($validated),
            'Updated successfully',
            route('admin.variation.index')
        );
    }


    public function destroy(Variation $variation)
    {
        return response()->report(
            $variation->delete(),
            'Deleted successfully',
        );
    }
}
