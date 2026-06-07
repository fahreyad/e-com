<?php

namespace App\Http\Controllers\FrontEnd;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Lib\SMS\ISMSSender;
use App\Models\Admin\BusinessSetting;
use App\Models\Admin\Product;
use App\Models\FrontEnd\Order;
use App\Models\FrontEnd\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $branch = session()->get('branch', []);
        return view('front-end.checkout.index', compact('cartItems', 'branch'));
    }

    public function store(Request $request)
    {
        $cartItems = session()->get('cart', []);

        // Validate request data
        $validated = $request->validate([
            'branch_id' => 'required|string|exists:branches,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'delivery_amount' => 'required|numeric|min:0',
            'delivery_area'   => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
        ]);


        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Product Not Added!');
        }

        // Try to find user or create a new one
        if (Auth::user()) {
            $user = User::where('id', Auth::user()->id)->first();
        }

        try {
            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => $user->id ?? null,
                'branch_id' => $validated['branch_id'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'note' => $validated['note'],
                'payment_method' => $validated['payment_method'],
                'delivery_method' => $validated['delivery_area'],
                'status' => OrderStatus::Pending,
                'order_number' => (Str::upper(business_setting('invoice_prefix')) ?? "RA") . rand(100000, 999999),
                'order_date' => Carbon::now()->format('d F Y'),
                'subtotal_amount' => collect(value: $cartItems)->sum(fn($item) => $item['price'] * $item['quantity']),
                'delivery_amount' => $validated['delivery_amount'],
                'total_amount' => $validated['total_amount'],
            ]);

            // Save Order Details
            foreach ($cartItems as $productId => $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'value' => $item['value'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }
            // Clear the cart session
            session()->forget('cart');

            DB::commit();
            $this->sendOrderSMS($order);


            return redirect()->route('thankyou.index')->with('success', 'Order placed successfully!')->with('last_order_id', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function thankYouPage()
    {
        // Optional: Retrieve last order from session
        $orderId = session('last_order_id');

        if (!$orderId) {
            return redirect()->route('home.index')->with('error', 'No recent order found.');
        }

        $order = Order::findOrFail($orderId);

        if (!$order) {
            return redirect()->route('home.index')->with('error', 'Order not found.');
        }
        return view('front-end.thankyou.index', compact('order'));
    }

    private function sendOrderSMS(Order $order)
    {
        $customerPhone = $order->phone;
        $branchPhone = $order->branch->phone;
        $adminPhone = BusinessSetting::where('key', 'alert_phone')->value('value');

        try {
            if ($customerPhone)
            app(ISMSSender::class)->send($customerPhone, "Your order have been placed successfully, we will get back to you as soon as possible thank you! [ www.mishtikotha.com ]");
        } catch (\Exception $e) {}

        try {
            if ($branchPhone)
            app(ISMSSender::class)->send($branchPhone, "one sale order created from this Customer $customerPhone");
        } catch (\Exception $e) {}

        try {
            if ($adminPhone)
            app(ISMSSender::class)->send($adminPhone, "one sale order created from this Customer $customerPhone");
        } catch (\Exception $e) {}
    }
}
