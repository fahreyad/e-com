<x-guest-layout title="Products">
    {{-- Product Banner Section  --}}
    <section class="banner-section relative" id="bannerSection">
        <div class="img_box ">
            <img class="w-full h-[200px] md:h-full object-cover"
                src="{{ business_image('banner_products') ? business_image('banner_products') : asset('front-end/assets/images/banner-img/products-banner-bg.png') }}" alt="">
            <!-- Centered Title -->
            <div class="section_title absolute z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <h2 class="text-[20px] md:text-[35px] text-center text-white">All Products</h2>
            </div>
            <!-- Description Section -->
        </div>
    </section>

    <!-- Product Section Start -->
    <section class="product_section" id="productSection">
        <x-breadcrumb></x-breadcrumb>
        <div class="container mx-auto py-6 md:py-10 px-4 md:px-0">
            @if (count($products) > 0)
                <div class="flex flex-col md:flex-row gap-6">
                    @livewire('product-filter')
                </div>
            @else
                <div class="product_section py-12 md:py-[60px] bg-gray-50">
                    <h2 class="text-center text-red-600 text-3xl">Sorry, Product Not Found!</h2>
                </div>
            @endif
        </div>
    </section>
    <!-- Product Section End -->

</x-guest-layout>
