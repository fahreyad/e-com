<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\CorporateOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CorporateOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = CorporateOrders::with(['corporateOrderDetails', 'branch'])->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('item_count', function ($order) {
                    return $order->corporateOrderDetails->count();
                })
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('admin.corporate-order.index');
    }

    public function show($id)
    {
        $order = CorporateOrders::with(['corporateOrderDetails', 'branch'])->findOrFail($id);  

        return view('admin.corporate-order.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'status' => 'required',
        ]);

        $order = CorporateOrders::with('corporateOrderDetails')->findOrFail($id);
        try {
            DB::beginTransaction();
            if ($validation['status']  == OrderStatus::Pending) {
                $order->status = $validation['status'];
            } else if ($validation['status']  == OrderStatus::Processing) {
                $order->status = $validation['status'];
                $order->processing_date = Carbon::now();
            } else if ($validation['status']  == OrderStatus::Delivered) {
                $order->status = $validation['status'];
                $order->delivered_date = Carbon::now();
            } else if ($validation['status']  == OrderStatus::Cancelled) {
                $order->status = $validation['status'];
                $order->cancelled_date = Carbon::now();
            }

            DB::commit();

            return response()->report(
                $order->save(),
                'Status Update Successfully',
            );
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            report($e);
            return response()->report(
                false,
                'Something went wrong! Try again.',
            );
        }
    }


    public function downloadInvoice($id)
    {
        $order = CorporateOrders::with(['corporateOrderDetails', 'branch'])->findOrFail($id);

        $pdf = Pdf::loadView('orders.corporate-order-invoice', compact('order'));
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function corporateOrdersBranch(Request $request, $branch_name, $branch_id){
 if ($request->ajax()) {
            $orders = CorporateOrders::where('branch_id', $branch_id)->with(['corporateOrderDetails', 'branch'])->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('item_count', function ($order) {
                    return $order->corporateOrderDetails->count();
                })
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        
        return view('admin.corporate-order.branch', compact('branch_name', 'branch_id'));
    }
}
