<x-guest-layout title="Home">

    {{-- Slider Section Start  --}}
    @include('front-end.home.slider')
    {{-- Slider Section End  --}}

    <!-- Popular Category Section Start -->
    <section id="popularCategory" class="popular_category_section py-8 px-3 md:px-0">
        <div class="container mx-auto">
            <div class="mb-5">
                <h2 class="section_title">Popular Category</h2>
            </div>
            <div class="popular_category_cards grid grid-cols-1 md:grid-cols-3 gap-4 pb-6">
                @foreach ($popularCategories as $index => $item)
                    <div class="category_body">
                        <div class="img_box">
                            <!-- cat_info above the image -->
                            {{-- <div class="cat_info">
                                <h4 class="title-4">{{ $item->category_name }}</h4>
                                <p class=" my-2.5"><span class="text-[#FEF1A1]">{{ $item->products->count() }}</span>
                                    Products</p>
                                <a class="inline title-5" href="{{ route('category.show', $item->slug) }}">
                                    Shop Now
                                    <img class="inline ml-1 w-[13px] h-[16px]"
                                        src="{{ asset('front-end/assets/images/icons/font-icon/circle-arrow.png') }}"
                                        alt="">
                                </a>
                            </div> --}}
                            <!-- image -->
                            <a href="{{ route('category.show', $item->slug) }}">
                                <div class="w-full h-full">
                                    <img class="w-full h-full c_border rounded object-cover "
                                        src="{{ $item->banner_image }}" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($categories))
                <!-- Category Slider Start -->
                <div class="cat_slider responsive autoplay mt-6">
                    @foreach ($categories as $index => $item)
                        <div class="mx-auto !h-auto">
                            <a href="{{ route('category.show', $item->slug) }}">

                                <div class="flex justify-center">
                                    <div class="img_box w-[70px] h-[70px] " title="{{ $item->category_name }}">
                                        <img class="w-full h-full" src="{{ $item->image }}"
                                            alt="{{ $item->category_name }}">
                                    </div>
                                </div>
                                <p class="!m-0 title-6  text-center">{{ $item->category_name }}</p>

                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Category Slider End -->
            @endif
        </div>
    </section>
    <!-- Popular Category Section End -->

    <!-- Products Section Start -->
    <section id="productSection" class="product_section py-8 px-4 md:px-0">
        <div class="container mx-auto">
            <div class="mb-5">
                <h2 class="section_title">All Products</h2>
            </div>
            <div class="products_cards grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($products as $index => $item)
                    <div class="product_content p_body p-3 bg-white">
                        <div class="img_box relative">
                            <img class="w-full h-full" src="{{ $item->image }}" alt="{{ $item->name }}">
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
                                    <p class="price mt-3">৳{{ number_format($item->regular_price) }}</p>
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
                @endforeach
            </div>
        </div>
    </section>
    <!-- Products Section End -->

    <!-- One Banner Section Start -->
    <section id="oneBannerSection" class="banner_section py-8 ">
        {{-- <div class="container mx-auto"> --}}
        <div class="img_box">
            <img class="w-full h-full"
                src="{{ filled(business_image('one_banner')) ? business_image('one_banner') : asset('front-end/assets/images/banner-img/home-banner-img-1.png') }}"
                alt="">
        </div>
        {{-- </div> --}}
    </section>
    <!-- One Banner Section End -->


    <!-- Products Section Start -->
    <section id="productSection" class="cat_product_1 product_section px-3 md:px-0">
        <div class="container mx-auto">
            <div class="mb-5">
                <h2 class="section_title">
                    {{ count($homeTopProducts) > 0 ? $homeTopProducts[0]->category->category_name : 'Cake' }}</h2>
            </div>
            <div class="products_cards grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($homeTopProducts as $index => $item)
                    <div class="product_content p_body p-3 bg-white">
                        <div class="img_box relative">
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
                                    <p class="price mt-3">৳{{ number_format($item->regular_price) }}</p>
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
                @endforeach

            </div>
        </div>
    </section>
    <!-- Products Section End -->

    <!-- Deal Sale Section Start -->
    <section id="dealSaleSection" class="deal_sale_section py-10 px-3 md:px-0">
        <div class="container mx-auto p-6 c_border_radius">
            <div class="deal_sale_content grid grid-cols-1 md:grid-cols-2 gap-5 items-center">

                <div class="outlet_slider">
                    @foreach ($outletSliders as $index => $item)
                        <div class="img_box w-full h-[200px] md:h-[280px] lg:h-[340px] xl:h-[450px]">
                            <img class="w-full h-full rounded" src="{{ $item->image }}" alt="">
                        </div>
                    @endforeach
                </div>

                <div class="time_count_content">
                    <h1 class="title-1">
                        {{ business_setting('best_deal_title') ?? __('Great Festive Deal Sale') }}
                    </h1>
                    <p class="common_text py-5">
                        {{ business_setting('best_deal_short_description') ?? __('Best deals, Low Prices , Great Offers Easy Delivery') }}
                    </p>
                    <div class="time_count grid grid-cols-2 lg:grid-cols-4 gap-2">
                        <div class="count_box text-center">
                            <h1 class="number" id="day">{{ business_setting('best_deal_day') ?? __('0') }}</h1>
                            <h3 class="time_name">Days</h3>
                        </div>
                        <div class="count_box text-center">
                            <h1 class="number" id="hour">{{ business_setting('best_deal_hour') ?? __('00') }}
                            </h1>
                            <h3 class="time_name">Hr</h3>
                        </div>
                        <div class="count_box text-center">
                            <h1 class="number" id="minute">{{ business_setting('best_deal_minute') ?? __('00') }}
                            </h1>
                            <h3 class="time_name">Min</h3>
                        </div>
                        <div class="count_box text-center">
                            <h1 class="number" id="second">00</h1>
                            <h3 class="time_name">Sc</h3>
                        </div>
                    </div>

                    <script>
                        // Get initial values from HTML
                        let days = parseInt(document.getElementById("day").innerText) || 0;
                        let hours = parseInt(document.getElementById("hour").innerText) || 0;
                        let minutes = parseInt(document.getElementById("minute").innerText) || 0;
                        let seconds = 0;

                        function updateCountdownDisplay() {
                            document.getElementById("day").innerText = String(days).padStart(2, '0');
                            document.getElementById("hour").innerText = String(hours).padStart(2, '0');
                            document.getElementById("minute").innerText = String(minutes).padStart(2, '0');
                            document.getElementById("second").innerText = String(seconds).padStart(2, '0');
                        }

                        function countdownTick() {
                            if (days === 0 && hours === 0 && minutes === 0 && seconds === 0) return;

                            if (seconds === 0) {
                                if (minutes === 0) {
                                    if (hours === 0) {
                                        if (days > 0) {
                                            days--;
                                            hours = 23;
                                            minutes = 59;
                                            seconds = 59;
                                        }
                                    } else {
                                        hours--;
                                        minutes = 59;
                                        seconds = 59;
                                    }
                                } else {
                                    minutes--;
                                    seconds = 59;
                                }
                            } else {
                                seconds--;
                            }

                            updateCountdownDisplay();
                        }

                        updateCountdownDisplay(); // initialize display

                        // Start countdown
                        setInterval(countdownTick, 1000);
                    </script>

                    <a href="{{ route('products.index') }}" class="block btn_other_2 mt-3">Shop Now > </a>
                </div>
            </div>


            <div class="products best_deal_product responsive mt-8">
                @foreach ($bestSaleProducts as $index => $item)
                    <div>
                        <div class="product_body flex">
                            <div class="img_box w-[110px] h-[110px] mr-3">
                                <img class="w-full h-full" src="{{ $item->image }}" alt="">
                            </div>
                            <div>
                                <a href="{{ route('products.show', $item->id) }}">
                                    <h6>{{ $item->name }}</h6>
                                </a>
                                <p class="price mt-2">৳
                                    {{ number_format($item->sale_price) ?? number_format($item->regular_price) }}</p>
                                <p class="section_title text-[12px]">Weight: <span
                                        class="price">{{ $item->value }}</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Deal Sale Section End -->


    <!-- Products Section Start -->
    <section id="productSection" class="cat_product_2 product_section px-3 md:px-0">
        <div class="container mx-auto">
            <div class="mb-5">
                <h2 class="section_title">
                    {{ count($homeMedialProducts) > 0 ? $homeMedialProducts[0]->category->category_name : 'Cake' }}
                </h2>
            </div>
            <div class="products_cards grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($homeMedialProducts as $index => $item)
                    <div class="product_content p_body p-3 bg-white">
                        <div class="img_box relative">
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
                                    <p class="price mt-3">৳{{ number_format($item->regular_price) }}</p>
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
                @endforeach

            </div>
        </div>
    </section>
    <!-- Products Section End -->

    <!-- Traditional Snacks Section Start -->
    <section id="traditionalSnacks" class="traditinonal_snacks_section py-10 px-3 md:px-0">
        <div class="container mx-auto">
            <div class="traditional_content flex flex-wrap gap-7">
                <div class="left_site w-full  lg:w-[32%] xl:w-[33%]">
                    <div class="img_box h-[300px] md:h-[400px] lg:h-[440px]">
                        <img class="w-full h-full"
                            src="{{ business_image('banner_two') ? business_image('banner_two') : asset('front-end/assets/images/bg-img/banner-bg-1.png') }}"
                            alt="">
                        <div class="info">
                            <h3 class="title-3">{{ business_setting('banner_two_title') }}</h3>
                            <a href="{{ business_setting('banner_two_link') ? business_setting('banner_two_link') : 'javascript:void(0)' }}"
                                class="btn_no_bg mt-[70px]">Explore
                                More</a>
                        </div>
                    </div>
                </div>
                <div class="right_site c_border_radius p-3 w-full lg:w-[64%] xl:w-[64.8%]">
                    <div class="responsive product_slider gap-5">
                        @if ($bannerTwoProducts)
                            @foreach ($bannerTwoProducts as $index => $item)
                                <div class="product_content p_body_2 p-2 my-1 mx-2 h-full bg-white">
                                    <div class="img_box w-full h-[200px] lg:h-[220px] xl:h-[250px] relative">
                                        <!-- Make img_box relative for positioning -->
                                        <img class="w-full h-full" src="{{ $item->image }}" alt="">

                                        <div class="offer_sign absolute top-0 z-10 w-full">
                                            <div class="flex justify-between items-center w-full">
                                                @if ($item->is_best_sale == \App\Enums\ProductStatus::BestSale)
                                                    <div class="best_sale relative">
                                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                            alt="" class="w-full">
                                                        <p
                                                            class="absolute inset-0 flex items-center text-white font-bold">
                                                            {{ \App\Enums\ProductStatus::BestSale()->description }}
                                                        </p>
                                                    </div>
                                                @endif

                                                @if ($item->is_hot_sale == \App\Enums\ProductStatus::NewArrival)
                                                    <div class="best_sale relative right-0">
                                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                            alt="" class="w-full">
                                                        <p
                                                            class="absolute inset-0 flex items-center text-white font-bold">
                                                            {{ \App\Enums\ProductStatus::NewArrival()->description }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product_info text-center">

                                        <a href="{{ route('products.show', $item->id) }}">
                                            <h4 class="p_name mt-3">{{ $item->name }}</h4>
                                        </a>
                                        @if ($item->is_variation == \App\Enums\ProductStatus::Variation)
                                            {{-- <p class="price mt-3">৳ 225</p> --}}
                                            <select class="price p-3 mt-3 c_border w-full rounded bg-[#FFFBF5]"
                                                name="product_variation_id" id="product_variation_id" required>
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
                                                    <span class="text-gray-500 line-through text-sm">
                                                        ৳ {{ number_format($item->regular_price) }}</span>
                                                    ৳ {{ number_format($item->sale_price) }}
                                                </p>
                                            @else
                                                <p class="price mt-3">৳ {{ number_format($item->regular_price) }}
                                                </p>
                                            @endif
                                            <p class="section_title text-[12px]">Weight: <span
                                                    class="price">{{ $item->value }}</span></p>
                                        @endif

                                        <div class="mt-4">
                                            <a href="{{ route('products.show', $item->id) }}"
                                                class="btn_option_1 p-2">
                                                Select Option</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Traditional Snacks Section End -->

    <!-- Products Section Start -->
    <section id="productSection" class="product_section py-8 px-3 md:px-0">
        <div class="container mx-auto">
            <div class="mb-5">
                <h2 class="section_title">
                    {{ count($homeBottomProducts) > 0 ? $homeBottomProducts[0]->category->category_name : 'Cake' }}
                </h2>
            </div>
            <div class="products_cards grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($homeBottomProducts as $index => $item)
                    <div class="product_content p_body p-3">
                        <div class="img_box relative">
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
                                    <p class="price mt-3">৳{{ number_format($item->regular_price) }}</p>
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
                @endforeach
            </div>
        </div>
    </section>
    <!-- Products Section End -->

    <!-- Traditional Snacks Section Start -->
    <section id="traditionalSnacks" class="cat_product_3 traditinonal_snacks_section pt-10 pb-20 px-3 md:px-0">
        <div class="container mx-auto">
            <div class="traditional_content flex flex-wrap gap-7">
                <div class="left_site w-full lg:w-[32%] xl:w-[33%]">
                    <div class="img_box h-[300px] md:h-[400px] lg:h-[440px]">
                        <img class="w-full h-full"
                            src="{{ business_image('banner_three') ? business_image('banner_three') : asset('front-end/assets/images/bg-img/banner-bg-2.png') }}"
                            alt="">

                        <div class="info">
                            <h3 class="title-3">{{ business_setting('banner_three_title') }}</h3>
                            <a href="{{ business_setting('banner_three_link') ? business_setting('banner_three_link') : 'javascript:void(0)' }}"
                                class="btn_no_bg mt-[70px]">Explore More</a>
                        </div>
                    </div>
                </div>
                <div class="right_site c_border_radius p-3 w-full lg:w-[64%] xl:w-[64.8%]">
                    <div class="responsive product_slider">

                        @if ($bannerThreeProducts)
                            @foreach ($bannerThreeProducts as $index => $item)
                                <div class="product_content p_body_2 p-3 my-1 mx-2 bg-white">
                                    <div class="img_box w-full h-[200px] lg:h-[220px] xl:h-[250px] relative">
                                        <!-- Make img_box relative for positioning -->
                                        <img class="w-full h-full" src="{{ $item->image }}" alt="">

                                        <div class="offer_sign absolute top-0 z-10 w-full">
                                            <div class="flex justify-between items-center w-full">
                                                @if ($item->is_best_sale == \App\Enums\ProductStatus::BestSale)
                                                    <div class="best_sale relative">
                                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                            alt="" class="w-full">
                                                        <p
                                                            class="absolute inset-0 flex items-center text-white font-bold">
                                                            {{ \App\Enums\ProductStatus::BestSale()->description }}
                                                        </p>
                                                    </div>
                                                @endif

                                                @if ($item->is_hot_sale == \App\Enums\ProductStatus::NewArrival)
                                                    <div class="best_sale relative right-0">
                                                        <img src="{{ asset('front-end/assets/images/arrow-red.png') }}"
                                                            alt="" class="w-full">
                                                        <p
                                                            class="absolute inset-0 flex items-center text-white font-bold">
                                                            {{ \App\Enums\ProductStatus::NewArrival()->description }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product_info text-center">

                                        <a href="{{ route('products.show', $item->id) }}">
                                            <h4 class="p_name mt-3">{{ $item->name }}</h4>
                                        </a>
                                        @if ($item->is_variation == \App\Enums\ProductStatus::Variation)
                                            {{-- <p class="price mt-3">৳ 225</p> --}}
                                            <select class="price p-3 mt-3 c_border w-full rounded bg-[#FFFBF5]"
                                                name="product_variation_id" id="product_variation_id" required>
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
                                                    <span class="text-gray-500 line-through text-sm">
                                                        ৳ {{ number_format($item->regular_price) }}</span>
                                                    ৳ {{ number_format($item->sale_price) }}
                                                </p>
                                            @else
                                                <p class="price mt-3">৳ {{ number_format($item->regular_price) }}
                                                </p>
                                            @endif
                                            <p class="section_title text-[12px]">Weight: <span
                                                    class="price">{{ $item->value }}</span></p>
                                        @endif

                                        <div class="mt-4">
                                            <a href="{{ route('products.show', $item->id) }}"
                                                class="btn_option_2 p-2">
                                                Select Option</a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Traditional Snacks Section End -->

    <x-slot name="script">
        {{-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.qtyBtn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const productContainer = this.closest('.product_info');
                        if (!productContainer) return;

                        const qtyInputs = productContainer.querySelectorAll('.qty-input');
                        let value = parseInt(qtyInputs[0].value) || 1;

                        if (this.dataset.action === 'increaseBtn') {
                            value++;
                        } else if (this.dataset.action === 'decreaseBtn' && value > 1) {
                            value--;
                        }

                        qtyInputs.forEach(input => {
                            input.value = value;
                        });
                    });
                });

                // Sync variation select with hidden inputs in forms
                document.querySelectorAll('.product_info').forEach(container => {
                    const productId = container.dataset.productId;
                    const variationSelect = container.querySelector(`#variation_select_${productId}`);

                    if (variationSelect) {
                        const buyNowVariationInput = container.querySelector(`#buyNow_variation_${productId}`);
                        const addToCartVariationInput = container.querySelector(
                            `#addToCart_variation_${productId}`);

                        // Initialize hidden inputs on page load
                        buyNowVariationInput.value = variationSelect.value;
                        addToCartVariationInput.value = variationSelect.value;

                        // On change update hidden inputs
                        variationSelect.addEventListener('change', () => {
                            buyNowVariationInput.value = variationSelect.value;
                            addToCartVariationInput.value = variationSelect.value;
                        });
                    }
                });
            });
        </script> --}}
    </x-slot>
</x-guest-layout>
