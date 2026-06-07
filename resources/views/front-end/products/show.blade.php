<x-guest-layout>

    <x-breadcrumb></x-breadcrumb>

    <section class="container mx-auto px-4 py-10 ">
        <div class="">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 ">

                <script src="https://unpkg.com/alpinejs" defer></script>

                <div x-data="{
                    images: @js(array_merge([$product->image], $product->gallery_image ?? [])),
                    currentIndex: 0,
                    get currentImage() {
                        return this.images[this.currentIndex];
                    },
                    prev() {
                        if (this.currentIndex > 0) this.currentIndex--;
                    },
                    next() {
                        if (this.currentIndex < this.images.length - 1) this.currentIndex++;
                    }
                }" class="flex flex-col md:flex-row gap-4 items-center md:items-start">

                    <!-- Gallery Arrows + Thumbnails -->
                    <div class="flex md:flex-col items-center gap-2 md:w-24 w-full justify-center md:justify-start">

                        <!-- Left Arrow -->
                        <button @click="prev"
                            class="p-2 bg-gray-200 hover:bg-gray-300 rounded shadow disabled:opacity-50"
                            :disabled="currentIndex === 0">

                            <span class="hidden md:block">
                                <svg class="w-6 h-6 " fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            </span>
                            <span class="md:hidden">
                                <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>

                        </button>

                        <!-- Thumbnails -->
                        <div class="flex md:flex-col gap-2 overflow-x-auto md:overflow-visible no-scrollbar px-1">
                            <template x-for="(image, index) in images" :key="index">
                                <img :src="image" @click="currentIndex = index"
                                    :class="currentIndex === index ? 'ring-2 ring-orange-500' : ''"
                                    class="w-20 h-16 md:h-20 object-cover rounded cursor-pointer hover:opacity-80 transition">
                            </template>
                        </div>

                        <!-- Right Arrow -->
                        <button @click="next"
                            class="p-2 bg-gray-200 hover:bg-gray-300 rounded shadow disabled:opacity-50"
                            :disabled="currentIndex === images.length - 1">
                            <span class="md:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                            <span class="hidden md:block">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>

                            </span>
                        </button>
                    </div>

                    <!-- Main Image -->
                    <div class="w-full md:flex-1 h-[270px] lg:h-[400px] xl:h-[550px] overflow-hidden rounded relative">
                        <img :src="currentImage" alt="Selected Image"
                            class="w-full h-full transition-transform duration-300 ease-in-out hover:scale-110">
                    </div>
                </div>

                <div class="product_info" data-product-id="{{ $product->id }}">

                    <h2 class="p_name mt-3 text-xl md:text-4xl font-semibold">{{ $product->name }}</h2>
                    @if ($product->is_variation == \App\Enums\ProductStatus::Variation)
                        <select class="price p-3 mt-3 c_border w-full rounded bg-[#FFFBF5]" name="variation_select"
                            id="variation_select_{{ $product->id }}" required>
                            @foreach ($product->productVariations as $varData)
                                <option value="{{ $varData->id }}">
                                    {{ $varData->variation_value }}
                                    ({{ $varData->sale_price > 0 ? number_format($varData->sale_price) : number_format($varData->regular_price) }}
                                    TK)
                                </option>
                            @endforeach
                        </select>
                    @else
                        @if ($product->sale_price)
                            <p class="price mt-3 md:text-2xl">
                                <span
                                    class="text-gray-500 line-through text-sm">৳{{ number_format($product->regular_price) }}</span>
                                ৳{{ number_format($product->sale_price) }}
                            </p>
                        @else
                            <p class="price mt-3 md:text-2xl">৳{{ $product->regular_price }}</p>
                        @endif
                        <p class="section_title text-[12px] md:text-md">Selected Net Weight: <span
                                class="price">{{ $product->value }}</span></p>
                    @endif

                    <p class="section_title text-[12px] md:text-xl">Category: <span
                            class="price">{{ $product->category->category_name }}</span></p>

                    <!-- Quantity Box -->
                    <div class="flex items-center space-x-3 mt-3">
                        <h3>Quantity :</h3>
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
                    </div>

                    <div class="btn_box flex items-center space-x-6 mt-2">
                        <form action="{{ route('add-to-cart') }}" method="post" id="buyNowForm_{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1" class="qty-input" />
                            <input type="hidden" name="product_variation_id"
                                id="buyNow_variation_{{ $product->id }}" />
                            <input type="hidden" name="status" value="{{ \App\Enums\ProductAddCartStatus::BuyNow }}">
                            <button type="submit" class="btn_buy_now">Buy Now</button>
                        </form>

                        <form action="{{ route('add-to-cart') }}" method="post"
                            id="addToCartForm_{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1" class="qty-input" />
                            <input type="hidden" name="product_variation_id"
                                id="addToCart_variation_{{ $product->id }}" />
                            <input type="hidden" name="status"
                                value="{{ \App\Enums\ProductAddCartStatus::AddToCart }}">
                            <button type="submit" class="btn_add_to_cart">Add To
                                Cart</button>
                        </form>
                    </div>

                    <!-- Short Description -->
                    @if ($product->short_description)
                        <div class="mt-3">
                            <p class="text-gray-700">{{ $product->short_description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-5">
            <!-- Full Description -->
            @if ($product->description)
                {{-- <h3 class="text-xl font-bold my-3">Description: </h3> --}}
                <div class="prose max-w-none prose-sm text-gray-800 text-justify">
                    <span class="text-[#DA0428]">Description:</span> {!! $product->description !!}
                </div>
            @endif
        </div>

    </section>

    @if (!empty($relatedProducts))
        {{-- Relative Products Start  --}}
        <section id="relative_products" class="product_section pt-12 bg-[#FDF8F1]">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="section_title mb-12">
                    <h2 class="text-md md:text-3xl font-extrabold">
                        Related Products
                    </h2>
                </div>

                <div class="products_cards related_product_slider responsive pb-12">
                    @foreach ($relatedProducts as $index => $item)
                        <div class="product_content p_body p-3 m-2 bg-white">
                            <div class="img_box w-[125px] h-[125px] relative">
                                <!-- Make img_box relative for positioning -->
                                <img class="w-full h-full" src="{{ $item->image }}" alt="">

                                <div class="offer_sign absolute top-0 z-10 w-full">
                                    <div class="flex justify-between items-center w-full">
                                        @if ($item->is_best_sale == \App\Enums\ProductStatus::BestSale)
                                            <div class="best_sale relative">
                                                <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                    alt="" class="w-full">
                                                <p class="absolute inset-0 flex items-center text-white font-bold">
                                                    {{ \App\Enums\ProductStatus::BestSale()->description }}
                                                </p>
                                            </div>
                                        @endif

                                        @if ($item->is_hot_sale == \App\Enums\ProductStatus::NewArrival)
                                            <div class="best_sale relative right-0">
                                                <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                    alt="" class="w-full">
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


    <x-slot name="script">
        <script>
            function increaseQty() {
                const qtyInput = document.getElementById('quantity');
                let value = parseInt(qtyInput.value);
                qtyInput.value = isNaN(value) ? 1 : value + 1;
            }

            function decreaseQty() {
                const qtyInput = document.getElementById('quantity');
                let value = parseInt(qtyInput.value);
                if (!isNaN(value) && value > 1) {
                    qtyInput.value = value - 1;
                }
            }
        </script>

    </x-slot>
</x-guest-layout>
