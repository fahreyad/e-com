<x-app-layout>

    <div class="max-w-4xl mx-auto ">

        <div class="flex justify-between mb-6">
            <a href="{{ route('my-orders.index') }}"
                class="inline-block px-6 py-2 bg-yellow-600 border border-gray-300 rounded text-white hover:bg-yellow-700 transition">
                Back
            </a>

            {{-- <button onclick="printInvoice()"
                class="inline-block px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Print Invoice
            </button> --}}


            <a href="{{ route('orders.invoice', $order->id) }}"
                class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Download Invoice
            </a>
        </div>
        <div class="invoice-body p-8 bg-white shadow-lg rounded">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <img class="w-2320" src="{{ business_image('logo') }}"
                            alt="{{ business_setting('website_name') }}">
                    </h1>
                    <p><span class="font-semibold">Address:</span> {{ business_setting('address') }}</p>
                    <p><span class="font-semibold">Email:</span> {{ business_setting('email') }}</p>
                    <p><span class="font-semibold">Phone:</span> {{ business_setting('phone') }}</p>
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
                    <div class="text-gray-700 space-y-1">
                        @if (!isset($order->user_id))
                            <p><span class="font-semibold">User Type:</span> {{ 'Guest User' }}</p>
                        @endif
                        <p><span class="font-semibold">Name:</span> {{ $order->name }}</p>
                        <p><span class="font-semibold">Phone:</span> {{ $order->phone }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $order->email ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Address:</span> {{ $order->address ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Branch Info:</h3>
                    <div class="text-gray-700 space-y-1">
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
                        @foreach ($order->orderDetails as $index => $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <img width="50px" src="{{ $detail->product->image }}" alt="">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $detail->product->name ?? 'N/A' }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ $detail->value }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    {{ number_format($detail->quantity) }}</td>
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
                <p>If you have any questions, please contact our support team at : {{ business_setting('email') }}</p>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            function printInvoice() {
                const invoiceContent = document.querySelector('.invoice-body').innerHTML;

                const printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write('<html><head><title>Print Invoice</title>');

                printWindow.document.write('<style>');
                printWindow.document.write(`
            body { font-family: Arial, sans-serif; margin: 20px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ccc; padding: 8px; }
            th { background: #f0f0f0; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
        `);
                printWindow.document.write('</style>');

                printWindow.document.write('</head><body>');
                printWindow.document.write(invoiceContent);
                printWindow.document.write('</body></html>');

                // printWindow.document.close();
                printWindow.focus();

                printWindow.print();
                // printWindow.close();
            }
        </script>


    </x-slot>
</x-app-layout>
