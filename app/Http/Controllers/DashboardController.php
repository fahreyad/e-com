<?php

namespace App\Http\Controllers;

use App\Lib\Card;
use App\Models\FrontEnd\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $cards = [];      

        $cards = array_merge($cards, [
            // Card::make('Total DPS', Auth::user()->dps()->count()),
            Card::make('Total New Orders', Auth::user()->orders()->where('status', '=', \App\Enums\OrderStatus::Pending())->count()),
            Card::make('Total Processing', Auth::user()->orders()->where('status', '=', \App\Enums\OrderStatus::Processing())->count()),
            Card::make('Total Delivered', Auth::user()->orders()->where('status', '=', \App\Enums\OrderStatus::Delivered())->count()),
            Card::make('Total Cancelled', Auth::user()->orders()->where('status', '=', \App\Enums\OrderStatus::Cancelled())->count()),
            Card::make('Total Orders', Auth::user()->orders()->count()),

        ]);
        return view('dashboard', compact('cards'));
    }
}
