<div class="flex flex-col md:flex-row gap-6">
    <!-- Sidebar Filters -->
    <aside class="w-full md:w-1/4 space-y-6">
        <!-- Categories -->
        <div class="border p-4 rounded shadow-sm bg-white">
            <h4 class="text-lg font-semibold mb-3">Product categories</h4>
            @foreach ($allCategories as $category)
                <label class="flex items-center space-x-2 mb-1">
                    <input type="checkbox" wire:model="selectedCategories" value="{{ $category->id }}"
                        class="form-checkbox text-orange-500">
                    <span>{{ $category->category_name }}</span>
                </label>
            @endforeach
        </div>

        <!-- Price -->
        <div class="border p-4 rounded shadow-sm bg-white">
            <h4 class="text-lg font-semibold mb-3">Filter by price</h4>
            <div class="flex gap-2">
                <input type="number" wire:model="priceMin" placeholder="Min"
                    class="w-1/2 border rounded px-2 py-1 text-sm">
                <input type="number" wire:model="priceMax" placeholder="Max"
                    class="w-1/2 border rounded px-2 py-1 text-sm">
            </div>
        </div>

        <!-- Weight -->
        <div class="border p-4 rounded shadow-sm bg-white">
            <h4 class="text-lg font-semibold mb-3">Filter by</h4>
            @foreach ($weights as $weight)
                <label class="flex items-center space-x-2 mb-1">
                    <input type="checkbox" wire:model="selectedWeights" value="{{ $weight }}"
                        class="form-checkbox text-orange-500">
                    <span>{{ $weight }}</span>
                </label>
            @endforeach
        </div>
    </aside>

    <!-- Product Grid -->
    <div class="w-full md:w-3/4">
        <div class="products_cards grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse ($products as $index => $item)
                <div class="product_content p_body p-3">
                    <div class="img_box w-[125px] h-[125px] relative"> <!-- Make img_box relative for positioning -->
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
                            <select class="price p-3 mt-3 c_border w-full rounded bg-[#FFFBF5]" name="variation_select"
                                id="variation_select_{{ $item->id }}" required>
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
                            <div class="quantity flex items-center c_border rounded overflow-hidden w-fit p-0.5">
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
            @empty
                <div class="text-center shadow-lg rounded-lg py-10">
                    <p class="text-red-600 text-3xl font-bold ">No products found!
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
