<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice PDF</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            box-sizing: border-box;
            color: #000 !important;
            /* enforce black globally */
        }

        .container {
            width: 700px;
            margin: 0 auto;
            background: #fff;
            color: #000 !important;
        }

        .header {
            color: #000 !important;
        }

        .company-info h1 {
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 600;
            color: #000 !important;
        }

        .company-info p {
            margin: 0;
            font-size: 11px;
            color: #000 !important;
        }

        .invoice-details,
        .bill-to {
            font-size: 12px;
            color: #000 !important;
        }

        .invoice-details h2 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #000 !important;
        }

        .invoice-details p,
        .bill-to p {
            margin: 3px 0;
            color: #000 !important;
        }

        .invoice-details p strong,
        .bill-to p strong {
            display: inline-block;
            width: 100px;
            color: #000 !important;
        }

        .bill-to h3 {
            font-size: 16px;
            margin-bottom: 8px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 4px;
            color: #000 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            color: #000 !important;
        }

        th,
        td {
            border: 1px solid #e0e0e0;
            padding: 8px;
            text-align: left;
            color: #000 !important;
        }

        th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            font-size: 10px;
            color: #000 !important;
        }

        td {
            font-size: 11px;
            color: #000 !important;
        }

        .text-right {
            text-align: right;
            color: #000 !important;
        }

        .text-center {
            text-align: center;
            color: #000 !important;
        }

        .product-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #eee;
        }

        .total-summary {
            max-width: 300px;
            margin-left: auto;
            /* changed from blue to black */
            padding-top: 10px;
            text-align: right;
            color: #000 !important;
        }

        .total-summary p {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 13px;
            color: #000 !important;
        }

        .total-summary p strong {
            color: #000 !important;
        }

        .total-summary .final-total {
            font-size: 16px;
            font-weight: bold;
            color: #007bff !important;
            /* only total price stays blue */
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #000 !important;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div style="display: flex;" class="header">
            <table>
                <tbody>
                    <tr>
                        <td style="border: none;">
                            <div class="company-info">
                                <h1>
                                    @php
                                        $path = public_path('storage/' . business_setting('logo'));
                                        $imageData = file_exists($path)
                                            ? base64_encode(file_get_contents($path))
                                            : null;
                                        $mime = file_exists($path) ? mime_content_type($path) : null;
                                    @endphp

                                    @if ($imageData)
                                        <img width="60" src="data:{{ $mime }};base64,{{ $imageData }}"
                                            alt="{{ business_setting('website_name') }}">
                                    @else
                                        {{ business_setting('website_name') }}
                                    @endif
                                </h1>
                                <p style="font-size: 14px;"><strong>Address: {{ business_setting('address') }}</strong>
                                </p>
                                <p style="font-size: 14px;"><strong>Email: {{ business_setting('email') }}</strong> </p>
                                <p style="font-size: 14px;"><strong>Phone: {{ business_setting('phone') }}</strong> </p>
                            </div>
                        </td>
                        <td style="border: none;">
                            <div style="text-align: right;">
                                <div class="invoice-details">
                                    <h2>Invoice</h2>
                                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>

                                    <p><strong>Order Date:</strong>
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                    </p>

                                    <p><strong>Order Status:</strong>
                                        @if ($order->status->value === \App\Enums\OrderStatus::Pending)
                                            <span style="color:#ca8a04 "> {{ $order->status->key }}</span>
                                        @elseif ($order->status->value === \App\Enums\OrderStatus::Processing)
                                            <span style="color: blue"> {{ $order->status->key }}</span>
                                        @elseif ($order->status->value === \App\Enums\OrderStatus::Delivered)
                                            <span style="color: green"> {{ $order->status->key }}</span>
                                        @else
                                            <span style="color: red"> {{ $order->status->key }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <!-- Table layout for Bill To + Invoice Info -->
        <table width="100%" style="margin-bottom: 20px;">
            <tr>
                <td width="50%" valign="top">
                    <div class="bill-to">
                        <h3>Bill To:</h3>
                        @if (!isset($order->user_id))
                            <p><strong>User Type:</strong> {{ 'Guest User' }}</p>
                        @endif
                        <p><strong>Name:</strong> {{ $order->name }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
                    </div>
                </td>
                <td width="50%" valign="top">
                    <div class="bill-to">
                        <h3>Branch Info</h3>
                        <p><strong>Branch Name:</strong> {{ $order->branch->name }}</p>
                        <p><strong>Phone:</strong> {{ $order->branch->phone }}</p>
                        <p><strong>Email:</strong> {{ $order->branch->email ?? 'N/A' }}</p>
                        <p><strong>Location:</strong> {{ $order->branch->location ?? 'N/A' }}</p>
                    </div>
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th width="5%">SN</th>
                    <th width="10%">Image</th>
                    <th>Product</th>
                    <th class="text-center" width="10%">Weight</th>
                    <th class="text-center" width="10%">Qty</th>
                    <th class="text-right" width="15%">Unit Price (TK)</th>
                    <th class="text-right" width="15%">Subtotal (TK)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @php
                                $path = public_path($detail->product->image);
                                $imageData = file_exists($path) ? base64_encode(file_get_contents($path)) : null;
                                $mime = file_exists($path) ? mime_content_type($path) : null;
                            @endphp

                            @if ($imageData)
                                <img width="80" src="data:{{ $mime }};base64,{{ $imageData }}"
                                    alt="Product Image">
                            @else
                                <p>N/A</p>
                            @endif
                        </td>

                        <td>{{ $detail->product->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $detail->value }}</td>
                        <td class="text-center">{{ (int) $detail->quantity }}</td>
                        <td class="text-right">{{ number_format($detail->price, 2) }}</td>
                        <td class="text-right">{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        <div class="total-summary">
            <p><strong>Subtotal:</strong> <span>TK {{ number_format($order->subtotal_amount, 2) }}</span></p>
            <p><strong>Delivery Charge:</strong> <span>TK {{ number_format($order->delivery_amount, 2) }}</span></p>
            <p class="final-total"><strong>Total:</strong> <span>TK {{ number_format($order->total_amount, 2) }}</span>
            </p>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>If you have any questions, please contact our support team at : {{ business_setting('email') }}</p>
            <p>{{ business_setting('website_name') }} &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>
