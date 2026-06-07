<x-guest-layout title="View Cart">
    <section id="viewCartPage" class="view_cart_page">
        <x-breadcrumb></x-breadcrumb>
        <div class="container mx-auto px-4 md:px-0 py-6">
            @if (count($cartItems) > 0)
                <h2 class="section_title text-[#922637] text-2xl font-semibold mb-6 ">YOUR CART</h2>
                <div class="bg-[#FDF8F1] px-5 py-3">
                    <h5 class="section_title text-sm">All Bangladesh Cash On Delivery</h5>
                </div>


                <div class="flex flex-wrap w-full">
                    <div class="w-full md:w-4/6 p-2">
                        <div class="p-4 shadow-md rounded-md bg-white">
                            <h3 class="section_title text-[20px] mb-2">Product</h3>
                            @php
                                $subtotal = 0;
                            @endphp
                            @foreach ($cartItems as $index => $item)
                                <div class="flex w-full justify-between mt-2">
                                    <div class="flex">
                                        <div class="img_box mr-3">
                                            <img width="100" src="{{ $item['image'] }}" alt="">
                                        </div>
                                        <div>
                                            <h5 class="font-semibold">{{ $item['name'] }} </h5>
                                            <p class="section_title text-sm mt-4">Net Weight : <span
                                                    class="price">{{ $item['value'] }}</span></p>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <h5 class="text-right font-semibold">
                                                <span class="total-price">
                                                    ৳ {{ number_format($item['price']) }}
                                                </span>
                                            </h5>

                                            <div class="flex space-x-3">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <button class="qty-btn bg-gray-200 px-2 py-1 rounded text-sm"
                                                        data-action="decrease"
                                                        data-index="{{ $index }}">-</button>
                                                    <span class="quantity">{{ $item['quantity'] }}</span>
                                                    <button class="qty-btn bg-gray-200 px-2 py-1 rounded text-sm"
                                                        data-action="increase"
                                                        data-index="{{ $index }}">+</button>
                                                </div>

                                                <form action="{{ route('cart.product-remove', $index) }}" method="POST"
                                                    onsubmit="return confirm('Remove this product?')">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 py-1 px-2 rounded-md">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $subtotal += $item['price'] * $item['quantity'];
                                @endphp
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full md:w-2/6 p-2">
                        <div class="p-4 shadow-md rounded-md bg-white">
                            <h3 class="section_title text-[20px] mb-2">Bill Details</h3>
                            <div class="flex justify-between items-center w-full">
                                <p>Subtotal</p>
                                <p class="subtotal">৳ {{ number_format($subtotal, 2) }}</p>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between items-center w-full">
                                <p class="section_title text-[16px]">GRAND TOTAL</p>
                                <p class="subtotal">৳ {{ number_format($subtotal, 2) }}</p>
                            </div>

                            <div class="mt-6 flex w-full space-x-4">
                                <a href="{{ route('checkout.index') }}"
                                    class="w-full text-center text-uppercase px-6 py-2 bg-[#FAAE43] rounded-md text-white font-semibold ">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7H18m-6-7v7" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 transition">Start
                        Shopping</a>
                </div>
            @endif
        </div>
    </section>



    @if (count($bestSaleProducts) > 0)
        {{-- Relative Products Start  --}}
        <section id="relative_products" class="product_section pt-12 bg-[#FDF8F1]">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="section_title mb-12">
                    <h2 class="text-md md:text-3xl font-extrabold">
                        Best Selling Products
                    </h2>
                </div>

                <div class="products_cards related_product_slider responsive pb-12">
                    @foreach ($bestSaleProducts as $index => $item)
                        <div class="product_content p_body p-3 m-3 bg-white">
                            <div class="img_box w-[125px] h-[125px] relative">
                                <!-- Make img_box relative for positioning -->
                                <img class="w-full h-full" src="{{ $item->image }}" alt="">

                               <div class="offer_sign absolute top-0 z-10 w-full">
                            <div class="flex justify-between items-center w-full">
                                @if ($item->is_best_sale == \App\Enums\ProductStatus::BestSale)
                                    <div class="best_sale relative">
                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}" alt=""
                                            class="w-full">
                                        <p class="absolute inset-0 flex items-center text-white font-bold">
                                            {{ \App\Enums\ProductStatus::BestSale()->description }}
                                        </p>
                                    </div>
                                @endif

                                @if ($item->is_hot_sale == \App\Enums\ProductStatus::NewArrival)
                                    <div class="best_sale relative right-0">
                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}" alt=""
                                            class="w-full">
                                        <p class="absolute inset-0 flex items-center text-white font-bold">
                                            {{ \App\Enums\ProductStatus::NewArrival()->description }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                            </div>

                            <div class="product_info" data-product-id="{{ $item->id }}">
                                <a href="{{ route('products.show', $item->id) }}">
                                    <h4 class="p_name mt-3">{{ $item->name }}</h4>
                                </a>

                                @if ($item->is_variation == \App\Enums\ProductStatus::Variation)
                                    <select class="price p-3 mt-3 c_border w-full rounded bg-[#FFFBF5]"
                                        name="variation_select" id="variation_select_{{ $item->id }}" required>
                                        @foreach ($item->productVariations as $varData)
                                            <option value="{{ $varData->id }}">
                                                {{ $varData->variation_value }}
                                                ({{ $varData->sale_price > 0 ? number_format($varData->sale_price) : number_format($varData->regular_price) }}
                                                TK)
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    @if ($item->sale_price)
                                        <p class="price mt-3">
                                            <span
                                                class="text-gray-500 line-through text-sm">৳{{ number_format($item->regular_price) }}</span>
                                            ৳{{ number_format($item->sale_price) }}
                                        </p>
                                    @else
                                        <p class="price mt-3">৳{{ $item->regular_price }}</p>
                                    @endif
                                    <p class="section_title text-[12px]">Selected Net Weight: <span
                                            class="price">{{ $item->value }}</span></p>
                                @endif

                                <div class="btn_box flex items-center justify-between mt-2">
                                    <!-- Quantity Box -->
                                    <div
                                        class="quantity flex items-center c_border rounded overflow-hidden w-fit p-0.5">
                                        <button type="button" class="qtyBtn px-2 py-1 text-lg font-semibold"
                                            data-action="decreaseBtn">-</button>
                                        <div class="w-12">
                                            <input type="number" name="quantity" value="1" min="1"
                                                class="qty-input p-0 w-full text-center border-0 focus:ring-0 focus:outline-none" />
                                        </div>
                                        <button type="button" class="qtyBtn px-2 py-1 text-lg font-semibold"
                                            data-action="increaseBtn">+</button>
                                    </div>

                                    <form action="{{ route('add-to-cart') }}" method="post"
                                        id="buyNowForm_{{ $item->id }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantity" value="1" class="qty-input" />
                                        <input type="hidden" name="product_variation_id"
                                            id="buyNow_variation_{{ $item->id }}" />
                                        <input type="hidden" name="status"
                                            value="{{ \App\Enums\ProductAddCartStatus::BuyNow }}">
                                        <button type="submit" class="btn_buy_now">Buy Now</button>
                                    </form>

                                    <form action="{{ route('add-to-cart') }}" method="post"
                                        id="addToCartForm_{{ $item->id }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantity" value="1" class="qty-input" />
                                        <input type="hidden" name="product_variation_id"
                                            id="addToCart_variation_{{ $item->id }}" />
                                        <input type="hidden" name="status"
                                            value="{{ \App\Enums\ProductAddCartStatus::AddToCart }}">
                                        <button type="submit" class="btn_add_to_cart">Add To
                                            Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>
        </section>
        {{-- Relative Products Start  --}}
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.qty-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.dataset.action;
                    const container = this.closest('.space-x-2');
                    const quantityEl = container.querySelector('.quantity');

                    let quantity = parseInt(quantityEl.textContent);
                    if (action === 'increase') quantity++;
                    if (action === 'decrease' && quantity > 1) quantity--;

                    quantityEl.textContent = quantity;

                    // Optionally update price or trigger form/ajax
                });
            });
        });
    </script>

</x-guest-layout>
