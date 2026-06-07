<?php

namespace App\Http\Controllers\Admin;

use App\Lib\Card;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\FrontEnd\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:admin.verification.notice');
    }


    public function index()
    {
        $cards = [];

        $branchOrder = Order::where('status', '=', \App\Enums\OrderStatus::Delivered())->with('branch')->get();

        foreach ($branchOrder->groupBy('branch.name') as $branchName => $orders) {
            $cards[] = Card::make($branchName, $orders->sum('subtotal_amount') . 'TK');
        }

        $cards = array_merge($cards, [


            Card::make('Total Products', Product::count()),
            Card::make('Total Categories', Category::count()),
            Card::make('Total Customer', User::count()),
            Card::make('Total New Order', Order::where('status', '=', \App\Enums\OrderStatus::Pending())->count()),
            Card::make('Total Processing', Order::where('status', '=', \App\Enums\OrderStatus::Processing())->count()),
            Card::make('Total Delivered', Order::where('status', '=', \App\Enums\OrderStatus::Delivered())->count()),
            Card::make('Total Cancelled', Order::where('status', '=', \App\Enums\OrderStatus::Cancelled())->count()),
            Card::make('Total Orders', Order::count()),

        ]);

        return view('admin.dashboard', compact('cards'));
    }
}
