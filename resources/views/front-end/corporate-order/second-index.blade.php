<x-guest-layout title="Corporate Order">

    @php
        $products = \App\Models\Admin\PackageProduct::all();        
    @endphp

    @include('front-end.corporate-order.banner')
    {{-- Page Main Content Section  --}}
    <section id="corporateOrderPage" class="corporate-order-page py-6 md:py-16">

        @if (count($products)> 0)
            <div class="w-full md:w-3/4 mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="section_title text-2xl font-semibold mb-4 text-gray-800">Customize Order</h2>

                <div class="flex">
                    <div class="w-full">
                        <form action="{{ route('corporate-order-add-to-cart.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-wrap items-center w-ful p-4">
                                <x-labeled-select label="Select
                            Product" id="product-select"
                                    name="product_id" class="select2 w-full" required>
                                    <option value="" disabled selected>Select Product</option>
                                    @foreach ($products as $index => $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}
                                            (৳ {{ number_format($product->sale_price ?? $product->regular_price) }})
                                        </option>
                                    @endforeach
                                </x-labeled-select>
                                <x-labeled-input name="quantity" type="number" min="1" value="1" required
                                    class="w-full" />

                                <div class="w-full md:w-auto md:mt-6">
                                    <x-button>
                                        {{ __('Add Product') }}
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="w-full p-2">
                        <div class="p-4 shadow-md rounded-md">
                            <h3 class="section_title text-[20px] mb-2">Package Details</h3>
                            @php
                                $deliveryCharges = \App\Models\Admin\DeliveryCharge::all();
                                $subtotal = 0;
                            @endphp

                            @if (count($cartItems) > 0)
                                <div>
                                    @foreach ($cartItems as $index => $item)
                                        <div class="flex justify-between items-center w-full my-1">
                                            <div>
                                                {{ $item['name'] }}<br>
                                                <span class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</span>
                                            </div>
                                            <div class="flex">
                                                <form class="mr-5"
                                                    action="{{ route('corporate-cart.remove-product', $index) }}"
                                                    method="POST" onsubmit="return confirm('Remove this product?')">
                                                    @csrf
                                                    @method('POST')
                                                    {{-- <button type="submit" class="text-red-600 hover:underline">&times;</button> --}}
                                                    <button title="Remove Item" type="submit"
                                                        class="text-xs text-red-600 hover:underline">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                                <p>৳ {{ number_format($item['price'] * $item['quantity']) }}</p>
                                            </div>
                                        </div>
                                        @php
                                            $subtotal += $item['price'] * $item['quantity'];
                                        @endphp
                                    @endforeach
                                </div>
                            @endif
                            <hr class="my-2">

                            <div class="flex justify-between items-center w-full">
                                <p>Subtotal</p>
                                <p id="subtotalDisplay" class="subtotal">৳ {{ number_format($subtotal) }}</p>
                            </div>

                            <form action="{{ route('corporate-order.store') }}" method="POST">
                                @csrf

                                <div class="w-full">
                                    <h3 class="font-semibold mb-2">Delivery Charge</h3>
                                    @if ($deliveryCharges->count() > 0)
                                        @foreach ($deliveryCharges as $deliveryCharge)
                                            <div class="flex justify-between items-center w-full mb-1">
                                                <label class="flex items-center space-x-2 cursor-pointer w-auto">
                                                    <input type="radio" name="delivery_charge"
                                                        value="{{ $deliveryCharge->amount }}"
                                                        class="delivery-charge-radio text-yellow-500"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <span>{{ $deliveryCharge->area }}</span>
                                                </label>
                                                <p>৳ {{ number_format($deliveryCharge->amount) }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex justify-between items-center w-full">
                                            <label class="flex items-center space-x-2 cursor-pointer">
                                                <input type="radio" name="delivery_charge" value="150"
                                                    class="delivery-charge-radio" checked>
                                                <span>All Bangladesh</span>
                                            </label>
                                            <p>৳ 150</p>
                                        </div>
                                    @endif
                                </div>

                                <hr class="my-2">

                                <div class="flex justify-between items-center w-full">
                                    <input type="hidden" name="total_amount"
                                        value="{{ $subtotal + ($deliveryCharges->first()->amount ?? 150) }}">
                                    <p class="section_title text-[16px]">GRAND TOTAL</p>
                                    <p id="grandTotal" class="total text-xl font-semibold text-green-600">৳
                                        {{ number_format($subtotal + ($deliveryCharges->first()->amount ?? 150), 2) }}
                                    </p>
                                </div>


                                <div class="mt-6 flex w-full space-x-4">
                                    <button type="submit"
                                        class="w-full text-center text-uppercase px-6 py-2 bg-[#FAAE43] rounded-md text-white font-semibold">
                                        Proceed to Checkout
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- <form action="{{ route('corporate-order.store') }}" method="POST">
                @csrf

                <input type="hidden" name="">
                <input type="hidden" name="">

                <div class="mt-6 flex w-full space-x-4">                   
                    <button type="submit"
                        class="w-full text-center text-uppercase px-6 py-2 bg-[#FAAE43] rounded-md text-white font-semibold">
                        Proceed to Checkout
                    </button>
                </div>
            </form> --}}

                {{-- </form> --}}

            </div>
        @else
            <div class="w-full md:w-3/4 mx-auto bg-white p-6 rounded-lg shadow-md text-center">
                <h2 class="text-2xl text-red-600 py-5 font-bold">Package Product Not Available</h2>
            </div>
        @endif

    </section>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('.delivery-charge-radio');
                const grandTotalElement = document.getElementById('grandTotal');
                const subtotalText = document.getElementById('subtotalDisplay');
                const subtotalValue = parseFloat(subtotalText.textContent.replace(/[^\d.-]/g, ''));

                function updateGrandTotal() {
                    let selectedDeliveryCharge = 0;
                    radios.forEach(radio => {
                        if (radio.checked) {
                            selectedDeliveryCharge = parseFloat(radio.value);
                        }
                    });

                    const grandTotal = subtotalValue + selectedDeliveryCharge;
                    grandTotalElement.textContent = '৳ ' + grandTotal.toFixed(2);
                }

                // Initial update
                updateGrandTotal();

                // Add event listener
                radios.forEach(radio => {
                    radio.addEventListener('change', updateGrandTotal);
                });
            });
        </script>

    </x-slot>

</x-guest-layout>
