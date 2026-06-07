<?php

namespace App\Http\Controllers\FrontEnd;

use App\Enums\OrderStatus;
use App\Lib\SMS\ISMSSender;
use App\Http\Controllers\Controller;
use App\Models\Admin\BusinessSetting;
use App\Models\Admin\DeliveryCharge;
use App\Models\Admin\PackageProduct;
use App\Models\CorporateOrderDetail;
use App\Models\CorporateOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CorporateOrderController extends Controller
{
    public function index()
    {
        $branch = session()->get('branch', []);
        return view('front-end.corporate-order.index', compact('branch'));
    }

    public function corporateOrderDetails(Request $request)
    {
        $validation = $request->validate([
            'user_id'        => 'nullable|exists:users,id',
            'branch_id'      => 'required|exists:branches,id',
            'contact_name'   => 'required|string|max:100',
            'company_name'   => 'nullable|string|max:150',
            'company_phone'  => 'required|string|max:20|regex:/^\+?[0-9\s\-\(\)]+$/',
            'designation'    => 'nullable|string|max:100',
            'email'          => 'required|email|max:100',
            'address'        => 'nullable|string|max:255',
            'note'           => 'nullable|string|max:255',
        ]);
        Session::put('corporateCustomerDetails', $validation);

        $corporateCustomerDetails = Session::get('corporateCustomerDetails');
        if ($corporateCustomerDetails) {
            return redirect()->route('corporate-next-page')->with('success', 'Create Package!');
        } else {

            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    public function corporateNextPage()
    {
        $corporateCustomerDetails = Session::get('corporateCustomerDetails');
        if (!$corporateCustomerDetails) {
            return redirect()->route('corporate-order.index')->with('error', 'Not Found Order Details!');
        }
        $cartItems = session()->get('corporate-cart', []);

        return view('front-end.corporate-order.second-index', compact('corporateCustomerDetails', 'cartItems'));
    }

    public function corporateOrderAddToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric'
        ]);

        $id = $validated['product_id'];
        $product = PackageProduct::findOrFail($id);
        $cart = session()->get('corporate-cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'value' => $product->value,
                'image' => $product->image,
                'price' => $product->sale_price ?? $product->regular_price,
                'quantity' => $validated['quantity']
            ];
        }
        session()->put('corporate-cart', $cart);

        return redirect()->back()->with('success', 'Product added!');
    }

    public function corporateOrderRemoveProduct($id)
    {
        $cart = session()->get('corporate-cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove the item
            session()->put('corporate-cart', $cart); // Save updated cart
        }
        return redirect()->back()->with('success', 'Product Removed!');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $deliveryMethod = DeliveryCharge::where('amount', '=', $validated['delivery_charge'])->first();

        $corporateOrderDetails = session()->get('corporateCustomerDetails');

        $cartItems = session()->get('corporate-cart');
        if (!$request->has('_token')) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        if (!$cartItems) {
            return redirect()->back()->with('error', 'Product Not Added!');
        }

        if (!$corporateOrderDetails) {
            return redirect()->route('corporate-order.index')->with('error', 'Not Found Order Details!');
        }

        try {
            DB::beginTransaction();

            // Create Order
            $order = CorporateOrders::create([
                'user_id' => $user->id ?? null,
                'contact_name' => $corporateOrderDetails['contact_name'],
                'company_name' => $corporateOrderDetails['company_name'],
                'company_phone' => $corporateOrderDetails['company_phone'],
                'designation' => $corporateOrderDetails['designation'],
                'email' => $corporateOrderDetails['email'],
                'address' => $corporateOrderDetails['address'],
                'note' => $corporateOrderDetails['note'],
                'branch_id' => $corporateOrderDetails['branch_id'],
                'payment_method' => 'Cash On Delivery',
                'delivery_area' => $deliveryMethod->area ?? 'All Bangladesh',
                'status' => OrderStatus::Pending,
                'order_number' => (\Illuminate\Support\Str::upper(business_setting('invoice_prefix')) ?? "RA") . rand(100000, 999999),
                'order_date' => Carbon::now()->format('d F Y'),
                'subtotal_amount' => collect(value: $cartItems)->sum(fn($item) => $item['price'] * $item['quantity']),
                'delivery_amount' => $deliveryMethod->amount ?? '150',
                'total_amount' => $validated['total_amount'],
            ]);

            // Save Order Details
            foreach ($cartItems as $productId => $item) {
                CorporateOrderDetail::create([
                    'corporate_order_id' => $order->id,
                    'product_id' => $productId,
                    'value' => $item['value'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }
            // Clear the cart session
            session()->forget('corporate-cart');
            DB::commit();
            $this->sendOrderSMS($order);

            return redirect()->route('corporate-thankyou.index')->with('success', 'Corporate Order placed successfully!')->with('last_corporate_order_id', $order->id);
            // return redirect()->back()->with('success', 'Good Job!');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'something went wrong!');
        }
    }

    public function corporateThankYouPage()
    {
        // Optional: Retrieve last order from session
        $orderId = session('last_corporate_order_id');
        if (!$orderId) {
            return redirect()->route('home.index')->with('error', 'No recent order found.');
        }

        $order = CorporateOrders::with(['branch'])->findOrFail($orderId);

        if (!$order) {
            return redirect()->route('home.index')->with('error', 'Order not found.');
        }

        return view('front-end.thankyou.corporate-thankyou', compact('order'));
    }


    private function sendOrderSMS(CorporateOrders $order)
    {
        $customerPhone = $order->company_phone;
        $branchPhone = $order->branch->phone;
        $adminPhone = BusinessSetting::where('key', 'alert_phone')->value('value');

        try {
            if ($customerPhone)
                app(ISMSSender::class)->send($customerPhone, "Your corporate order have been placed successfully, we will get back to you as soon as possible thank you! [ www.mishtikotha.com ]");
        } catch (\Exception $e) {
        }

        try {
            if ($branchPhone)
                app(ISMSSender::class)->send($branchPhone, "one sale corporate order created from this Customer $customerPhone");
        } catch (\Exception $e) {
        }

        try {
            if ($adminPhone)
                app(ISMSSender::class)->send($adminPhone, "one sale corporate order created from this Customer $customerPhone");
        } catch (\Exception $e) {
        }
    }
}
