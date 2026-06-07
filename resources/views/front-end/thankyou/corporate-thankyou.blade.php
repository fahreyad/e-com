<x-guest-layout class="Thanks You">
    <section id="thankYouPage">
        <div class="container mx-auto p-8 shadow-md rounded m-10 mt-0">
            <div class="flex items-center justify-center">
                <div class="w-[200px] h-[180px] md:w-[300px] md:h-[260px]">
                    <img class="w-full h-full" src="{{ asset('front-end/assets/images/thank-you-img.gif') }}"
                        alt="">
                </div>
            </div>
            <div class="text-center mb-10">
                <h1
                    class="section_title text-center text-[28px] font-bold bg-gradient-to-r from-[#C4A237] to-[#E48500] bg-clip-text text-transparent">
                    Thank you for your Purchase</h1>
                <p
                    class="section_title text-center text-sm font-bold bg-gradient-to-r from-[#E18805] to-[#666666] bg-clip-text text-transparent">
                    Your Order Has Been Placed! You Will Receive an Email Receive Shortly</p>
            </div>

            <div class="my-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mt-5">
                        <h2 class="text-lg">Order Info</h2>
                        <p class="text-gray-600">Order ID: <span class="font-semibold">{{ $order->id }}</span></p>
                        <p class="text-gray-600">Order Number: <span
                                class="font-semibold">{{ $order->order_number }}</span>
                        </p>
                        <p class="text-gray-600">Order Date: <span
                                class="font-semibold">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</span>
                        </p>
                    </div>
                    <div>

                        <h2 class="text-lg">Branch Info</h2>
                        <p class="text-gray-600">Branch Name: <span
                                class="font-semibold">{{ $order->branch->name ?? 'N/A' }}</span>
                        </p>
                        <p class="text-gray-600">Phone: <span
                                class="font-semibold">{{ $order->branch->phone ?? 'N/A' }}</span>
                        </p>
                        <p class="text-gray-600">Email: <span
                                class="font-semibold">{{ $order->branch->email ?? 'N/A' }}</span>
                        </p>
                        <p class="text-gray-600">Location: <span
                                class="font-semibold">{{ $order->branch->location ?? 'N/A' }}</span>
                        </p>

                    </div>
                </div>
            </div>            

            <section class="mb-8">
                <h2 class="section_title text-xl font-semibold border-b pb-2 mb-4">Billing Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                    <div><span class="font-semibold">Name:</span> {{ $order->contact_name }}</div>
                    <div><span class="font-semibold">Company_name:</span> {{ $order->company_name ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Designation:</span> {{ $order->designation ?? 'N/A' }}</div>
                    <div><span class="font-semibold">Phone:</span> {{ $order->company_phone }}</div>
                    <div><span class="font-semibold">Email:</span> {{ $order->email }}</div>
                    <div><span class="font-semibold">Address:</span> {{ $order->address ?? 'N/A' }} </div>
                    <div><span class="font-semibold">Note:</span> {{ $order->note ?? 'N/A' }} </div>
                    <div><span class="font-semibold">Payment Method:</span>
                        {{ ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $order->payment_method)) }} </div>
                    <div><span class="font-semibold">Delivery Area:</span>
                        {{ ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $order->delivery_area)) }}</div>
                </div>
            </section>

            <section>
                <h2 class="section_title text-xl font-semibold border-b pb-2 mb-4">Order Details</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border border-gray-300 px-4 py-2 text-left">S/N</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Image</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-right">Weight</th>
                                <th class="border border-gray-300 px-4 py-2 text-right">Quantity</th>
                                <th class="border border-gray-300 px-4 py-2 text-right">Unit Price (TK)</th>
                                <th class="border border-gray-300 px-4 py-2 text-right">Subtotal (TK)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->corporateOrderDetails as $index => $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <img width="50" src="{{ $detail->packageProduct->image }}" alt=""> </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $detail->packageProduct->name ?? 'N/A' }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-right">
                                        {{ $detail->value }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-right">
                                        {{ (int) $detail->quantity }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-right">
                                        {{ number_format($detail->price, 2) }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-right">
                                        {{ number_format($detail->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 max-w-sm ml-auto space-y-1 text-gray-800">
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
                </div>
            </section>

            <div class="mt-10 text-center text-gray-600">
                <p>We appreciate your business! If you have any questions, please contact our support.</p>
            </div>
        </div>
    </section>
</x-guest-layout>
