<x-admin-app-layout>

    <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full bg-white p-5 rounded">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <img width="100" height="50" id="prevOneBanner" src="{{ business_image('one_banner') }}">
                <x-labeled-input label="Banner One Image (1350X400px)" type="file"
                    accept="image/jpeg,image/png,image/jpg,image/webp" name="one_banner" class="w-full p-1"
                    onchange="prevOneBanner.src=window.URL.createObjectURL(this.files[0])"
                    value="{{ business_setting('one_banner') }}" />

                <img width="80" id="prevBannerTwo" src="{{ business_image('banner_two') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-labeled-input label="Banner Two Image (450X430px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="banner_two" class="w-full p-1"
                        onchange="prevBannerTwo.src=window.URL.createObjectURL(this.files[0])"
                        value="{{ business_setting('banner_two') }}" />

                    <x-labeled-input label="Banner Two Title" type="text" name="banner_two_title" class="w-full p-1"
                        value="{{ business_setting('banner_two_title') }}" />

                    <x-labeled-input label="Banner Two Button Link" type="text" name="banner_two_link"
                        class="w-full p-1" value="{{ business_setting('banner_two_link') }}" />
                </div>

                <img width="80" id="prevBannerThree" src="{{ business_image('banner_three') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-labeled-input label="Banner Three Image (450X430px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="banner_three" class="w-full p-1"
                        onchange="prevBannerThree.src=window.URL.createObjectURL(this.files[0])"
                        value="{{ business_setting('banner_three') }}" />

                    <x-labeled-input label="Banner Three Title" type="text" name="banner_three_title"
                        class="w-full p-1" value="{{ business_setting('banner_three_title') }}" />

                    <x-labeled-input label="Banner Three Button Link" type="text" name="banner_three_link"
                        class="w-full p-1" value="{{ business_setting('banner_three_link') }}" />
                </div>

                <img width="100" id="prevCorporateBanner" src="{{ business_image('banner_corporate') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-labeled-input label="Corporate Banner Image (1400X400px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="banner_corporate" class="w-full p-1"
                        onchange="prevCorporateBanner.src=window.URL.createObjectURL(this.files[0])"
                        value="{{ business_setting('banner_corporate') }}" />

                    <x-labeled-input label="Corporate Banner Title" type="text" name="banner_corporate_title"
                        class="w-full p-1" value="{{ business_setting('banner_corporate_title') }}" />

                    <x-labeled-input label="Corporate Short Text" type="text" name="corporate_short_text"
                        class="w-full p-1" value="{{ business_setting('corporate_short_text') }}" />
                </div>

                <img width="100" id="prevProductBanner" src="{{ business_image('banner_products') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-labeled-input label="Product Page Banner Image (1400X400px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="banner_products" class="w-full p-1"
                        onchange="prevProductBanner.src=window.URL.createObjectURL(this.files[0])"
                        value="{{ business_setting('banner_products') }}" />
                </div>

                <div class="w-full
                            pt-4 flex justify-end">
                    <x-button>
                        {{ __('Update') }}
                    </x-button>
                </div>
        </div>

        </form>
    </div>


    </div>


</x-admin-app-layout>
