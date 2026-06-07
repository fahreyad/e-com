<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::where('user_id', Auth::id())->with('branch')->latest()->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded text-xs font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('my-order.index');
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails', 'branch'])->findOrFail($id);
        return view('my-order.show', compact('order'));
    }


    public function newOrders(Request $request)
    {

        if ($request->ajax()) {
            $orders = Order::where('user_id', Auth::id())->with('branch')->where('status', '=', \App\Enums\OrderStatus::Pending())->latest()->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded text-xs font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('my-order.new-order');
    }
    public function processingOrders(Request $request)
    {

        if ($request->ajax()) {
            $orders = Order::where('user_id', Auth::id())->with('branch')->where('status', '=', \App\Enums\OrderStatus::Processing())->latest()->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded text-xs font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('my-order.processing-order');
    }
    public function deliveredOrders(Request $request)
    {

        if ($request->ajax()) {
            $orders = Order::where('user_id', Auth::id())->with('branch')->where('status', '=', \App\Enums\OrderStatus::Delivered())->latest()->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded text-xs font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('my-order.delivered-order');
    }
    public function cancelledOrders(Request $request)
    {

        if ($request->ajax()) {
            $orders = Order::where('user_id', Auth::id())->with('branch')->where('status', '=', \App\Enums\OrderStatus::Cancelled())->latest()->orderBy('created_at', 'DESC')->get();

            return datatables($orders)
                ->addIndexColumn()
                ->addColumn('status', function ($order) {
                    $color = match ($order->status->value) {
                        0 => 'text-yellow-600 ',
                        1 => 'text-blue-600 ',
                        2 => 'text-green-600 ',
                        3 => 'text-red-600 ',
                        default => 'text-gray-600 '
                    };

                    return '<span class="px-2 py-1 rounded text-xs font-medium ' . $color . '">' .
                        $order->status->key . '</span>';
                })->rawColumns(['status'])
                ->toJson();
        }
        return view('my-order.cancelled-order');
    }
}
