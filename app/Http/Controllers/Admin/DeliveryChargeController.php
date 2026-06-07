<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DeliveryCharge;
use Illuminate\Http\Request;

class DeliveryChargeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables(DeliveryCharge::orderBy('created_at', 'asc'))
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.delivery-charge.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area' => 'required|string',
            'amount' => 'required|numeric'
        ]);
        return response()->report(
            DeliveryCharge::create($validated),
            'Created successfully',
        );
    }



    public function edit(DeliveryCharge $deliveryCharge)
    {
        return view('admin.delivery-charge.edit', compact('deliveryCharge'));
    }

    public function update(Request $request, DeliveryCharge $deliveryCharge)
    {
        // Validate input
        $validated = $request->validate([
            'area' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        // Return response
        return response()->reportTo(
            $deliveryCharge->update($validated),
            'Updated successfully',
            route('admin.delivery-charge.index')
        );
    }


    public function destroy(DeliveryCharge $deliveryCharge)
    {
        return response()->report(
            $deliveryCharge->delete(),
            'Deleted successfully',
        );
    }
}
