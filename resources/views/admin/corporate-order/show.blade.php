<x-admin-app-layout>

    <div class="max-w-4xl mx-auto">

        <div class="flex justify-between items-center mb-6">


            <!-- Order Status Form -->
            <form action="{{ route('admin.corporate-orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="status" class="block mb-1 text-sm font-medium text-gray-700">Order Status:</label>
                <div class="flex items-center space-x-4">
                    <select name="status" id="status"
                        class="w-64 px-4 py-2 border border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach (\App\Enums\OrderStatus::asSelectArray() as $key => $label)
                            @if ($order->status->value == \App\Enums\OrderStatus::Cancelled)
                                <option disabled selected value="{{ $key }}">
                                    {{ $label }}
                                </option>
                            @else
                                <option value="{{ $key }}"
                                    {{ $order->status->value === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endif
                        @endforeach

                    </select>
                    <button {{ $order->status->value == \App\Enums\OrderStatus::Cancelled ? 'disabled' : '' }}
                        type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Update Status
                    </button>
                </div>
            </form>


            <a href="{{ route('admin.corporate-orders.invoice', $order->id) }}"
                class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Download Invoice
            </a>
        </div>
        <div class="p-8 bg-white shadow-lg rounded">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <img class="w-16" src="{{ business_image('logo') }}"
                            alt="{{ business_setting('website_name') }}">
                    </h1>
                    <p><span class="font-semibold">Phone:</span> {{ business_setting('phone') }}</p>
                    <p><span class="font-semibold">Email:</span> {{ business_setting('email') }}</p>
                    <p><span class="font-semibold">Address:</span> {{ business_setting('address') }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">Invoice</h2>
                    <p><span class="font-semibold">Order Number #:</span> {{ $order->order_number }}</p>
                    <p><span class="font-semibold">Order Date:</span>
                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>

                    <p class="font-semibold"><span>Order Status:</span>
                        @if ($order->status->value === \App\Enums\OrderStatus::Pending)
                            <span class="text-yellow-600"> {{ $order->status->key }}</span>
                        @elseif ($order->status->value === \App\Enums\OrderStatus::Processing)
                            <span class="text-blue-600"> {{ $order->status->key }}</span>
                        @elseif ($order->status->value === \App\Enums\OrderStatus::Delivered)
                            <span class="text-green-600"> {{ $order->status->key }}</span>
                        @else
                            <span class="text-red-600"> {{ $order->status->key }}</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-8">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Bill To:</h3>
                    <div class="">
                        <p><span class="font-semibold">Contact Name:</span> {{ $order->contact_name }}</p>
                        <p><span class="font-semibold">Company Name:</span> {{ $order->company_name ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Designation:</span> {{ $order->designation ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Company Phone:</span> {{ $order->company_phone }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $order->email }}</p>
                        <p><span class="font-semibold">Address:</span> {{ $order->address ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Payment Method:</span> {{ $order->payment_method ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Delivery Area:</span> {{ $order->delivery_area ?? 'N/A' }}</p>
                    </div>
                    <p><span class="font-semibold">Note:</span> {{ $order->note ?? 'N/A' }}</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Branch Info:</h3>
                    <div class="">
                        <p><span class="font-semibold">Branch Name:</span> {{ $order->branch->name ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Phone:</span> {{ $order->branch->phone ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $order->branch->email ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Location:</span> {{ $order->branch->location ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Order Details Table --}}
            <section class="overflow-x-auto mb-8">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">SN</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Image</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Product</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Weight</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Qty</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Unit Price (TK)</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Subtotal (TK)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->corporateOrderDetails as $index => $detail)
                            
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <img width="50px" src="{{ $detail->packageProduct->image }}" alt="">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $detail->packageProduct->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $detail->value }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ (int) $detail->quantity }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-right">
                                    {{ number_format($detail->price, 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-right">
                                    {{ number_format($detail->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            {{-- Totals --}}
            <section class="max-w-sm ml-auto space-y-1 text-gray-800">
                <div class="flex justify-between font-semibold">
                    <span>Subtotal:</span>
                    <span>TK {{ number_format($order->subtotal_amount, 2) }}</span>
                </div>
                <div class="flex justify-between font-semibold">
                    <span>Delivery Charge:</span>
                    <span>TK {{ number_format($order->delivery_amount, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2">
                    <span>Total:</span>
                    <span>TK {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </section>

            {{-- Footer --}}
            <div class="mt-10 text-center text-gray-600 text-sm">
                <p>Thank you for shopping with us!</p>
                <p>If you have any questions, please contact our support team at : <span
                        class="font-semibold">{{ business_setting('email') }}</span></p>
            </div>
        </div>

    </div>
</x-admin-app-layout>
