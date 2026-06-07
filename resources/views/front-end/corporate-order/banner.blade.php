 <section class="banner-section relative" id="bannerSection">
        <div class="img_box">
            <img class="w-full h-[200px] md:h-full object-cover"
                src="{{ business_image('banner_corporate') ? business_image('banner_corporate') : asset('front-end/assets/images/banner-img/products-banner-bg.png') }}"
                alt="">
            <!-- Centered Title -->
            <div
                class="section_title w-full md:w-1/3 text-white text-center absolute z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <h2 class="text-[20px] md:text-[35px]">
                    {{ business_setting('banner_corporate_title') ?? 'Corporate Order' }}</h2>
                <p class="text-sm mt-5">
                    {{ business_setting('corporate_short_text') }}
                </p>
            </div>

            <div
                class="w-full md:w-3/4 mx-auto text-white bg-gradient-to-r from-[#CD9951] to-[#674D29] py-2 px-4 rounded -mb-5 absolute z-10 bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-0">
                <ul class="md:flex items-center justify-between text-center">
                    <li class="section_title text-[24px]"><span
                            class="bg-white rounded-full text-black inline-block w-8 h-8 text-center">1</span> Order
                        Form </li>
                    <li>-----------------------------------------</li>
                    <li class="section_title text-[24px]"><span
                            class="border rounded-full  inline-block w-8 h-8 text-center"">1</span> Customized Order
                    </li>
                </ul>
            </div>
        </div>
    </section>