<x-guest-layout title="Checkout">
    <section id="checkoutPage" class="checkout-page">
        <x-breadcrumb />

        <div class="max-w-7xl mx-auto px-4 md:px-0 py-10">
            <div class="page_title mb-2 md:mb-10">
                <h2
                    class="section_title text-center text-md md:text-3xl font-bold bg-gradient-to-r from-[#C4A237] to-[#E48500] bg-clip-text text-transparent">
                    Check Out
                </h2>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col lg:flex-row gap-1 md:gap-10">
                @csrf
                <!-- Left: Shipping + Payment -->
                <div class="flex-1 p-2 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full bg-white">
                        <x-labeled-input label="Full Name" name="name" required
                            value="{{ old('name', Auth::user()->name ?? '') }}" class="w-full" />
                        <x-labeled-input label="Phone Number" name="phone" required
                            value="{{ old('phone', Auth::user()->phone ?? '') }}" class="w-full" />
                        <x-labeled-textarea label="Address *" name="address" class="w-full"
                            value="{{ old('address', Auth::user()->address ?? '') }}" required />
                        <x-labeled-textarea label="Special Note" name="note" class="w-full" />
                        <x-labeled-select label="Select Branch" name="branch_id" class="w-full" required="true">
                            <option value="" disabled {{ empty($branch) ? 'selected' : '' }}>Select
                                Branch</option>
                            @if (!empty(\App\Models\Admin\Branch::all()))
                                @foreach (\App\Models\Admin\Branch::all() as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !empty($branch) && $item->id == $branch['id'] ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endif
                        </x-labeled-select>
                    </div>

                    <div class="mt-4">
                        <h3 class="text-xl font-semibold mb-4 border-b pb-3">Payment Method</h3>
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="payment_method" value="cashOnDelivery" checked required
                                class="form-radio text-blue-600">
                            <span>Cash on Delivery</span>
                        </label>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <aside class="bg-white w-full lg:w-1/3 h-full shadow rounded p-2 md:p-8">
                    <h3 class="section_title text-[20px] mb-6 border-b pb-3">BILL DETAILS</h3>

                    @php $subtotal = 0; @endphp
                    <div class="space-y-4">
                        @foreach ($cartItems as $index => $item)
                            <div class="flex items-center space-x-4 cart-item">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $item['name'] }} <span
                                            class="price">({{ $item['value'] }})</span></h4>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <button type="button" class="qty-btn bg-gray-200 px-2 py-1 rounded text-sm"
                                            data-action="decrease" data-index="{{ $index }}">-</button>
                                        <span class="quantity">{{ $item['quantity'] }}</span>
                                        <button type="button" class="qty-btn bg-gray-200 px-2 py-1 rounded text-sm"
                                            data-action="increase" data-index="{{ $index }}">+</button>
                                    </div>
                                </div>
                                <div class="text-end font-semibold text-gray-900">
                                    <a class="text-red-600 hover:underline"
                                        href="{{ route('cart.product-delete', $index) }}">&times;</a>
                                    <span class="total-price">৳
                                        {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            </div>
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </div>

                    <div class="border-t mt-4 pt-4 space-y-2 font-semibold text-gray-900">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="subtotal">৳ {{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Delivery Charge:</span>
                            <span id="delivery-charge">৳ 50.00</span>
                        </div>

                        <div class="space-y-2" id="delivery-options">
                            @foreach (\App\Models\Admin\DeliveryCharge::all() as $item)
                                <label class="text-sm flex items-center justify-between space-x-2">
                                    <span class="flex items-center space-x-2">
                                        <input type="radio" name="delivery_area" value="{{ $item->area }}"
                                            data-amount="{{ $item->amount }}" required
                                            {{ $loop->first ? 'checked' : '' }}
                                            class="form-radio text-blue-600 delivery-radio">
                                        <span>{{ $item->area }}</span>
                                    </span>
                                    <span class="font-bold">৳ {{ number_format($item->amount, 2) }}</span>
                                </label>
                            @endforeach
                        </div>

                        <hr>

                        @php $total_amount = $subtotal + 50; @endphp
                        <div class="section_title text-[18px] flex justify-between text-md md:text-lg">
                            <span>GRAND TOTAL:</span>
                            <span id="order-total">৳ {{ number_format($total_amount, 2) }}</span>
                        </div>

                        <input type="hidden" name="total_amount" id="total_amount_input" value="{{ $total_amount }}">
                        <input type="hidden" name="delivery_amount" id="delivery_amount_input" value="50">

                        <button type="submit"
                            class="w-full bg-[#FAAE43] text-white mt-6 py-3 rounded-md font-semibold shadow">
                            Proceed to Checkout
                        </button>
                    </div>
                </aside>
            </form>
        </div>
    </section>

    <!-- Precise addition helper function -->
    <script>
        function preciseAdd(a, b) {
            return (Math.round(a * 100) + Math.round(b * 100)) / 100;
        }
    </script>

    <!-- Delivery Charges + Total Update -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatter = new Intl.NumberFormat('en-BD', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            const deliveryRadios = document.querySelectorAll('.delivery-radio');
            const deliveryInput = document.getElementById('delivery_amount_input');
            const totalInput = document.getElementById('total_amount_input');
            const deliveryChargeEl = document.getElementById('delivery-charge');
            const totalAmountEl = document.getElementById('order-total');

            // This function is declared globally so other scripts can call it (e.g. qty update)
            window.updateTotals = function(amount) {
                const deliveryAmount = parseFloat(amount) || 0;
                const subtotalStr = document.querySelector('.subtotal').textContent.replace(/[^\d.-]/g, '') ||
                    '0';
                const subtotal = parseFloat(subtotalStr) || 0;

                const total = preciseAdd(subtotal, deliveryAmount);

                deliveryChargeEl.textContent = `৳ ${formatter.format(deliveryAmount)}`;
                totalAmountEl.textContent = `৳ ${formatter.format(total)}`;

                deliveryInput.value = deliveryAmount;
                totalInput.value = total.toFixed(2);
            }

            deliveryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    window.updateTotals(this.dataset.amount);
                });
            });

            // Init on page load:
            const selected = document.querySelector('.delivery-radio:checked');
            if (selected) {
                window.updateTotals(selected.dataset.amount);
            }
        });
    </script>

</x-guest-layout>
