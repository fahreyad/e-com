<x-admin-app-layout>

    {{-- <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="w-full md:w-1/2 bg-white p-4">
                    <img width="120" height="50" id="prevImage" src="{{ business_image('best_deal_img') }}">
                    <x-labeled-input label="Image (580X365px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="best_deal_img" class="w-full p-1"
                        onchange="prevImage.src=window.URL.createObjectURL(this.files[0])"
                        value="{{ business_setting('best_deal_img') }}" />

                    <x-labeled-input label="Section Title" name="best_deal_title" type="text"
                        value="{{ business_setting('best_deal_title') }}" class="w-full p-1" />

                    <x-labeled-textarea label="Short Description" name="best_deal_short_description" type="text"
                        value="{{ business_setting('best_deal_short_description') }}" class="w-full  p-1 " />  


                    <div class="w-full flex">
                        <x-labeled-input label="Day" name="best_deal_day" type="number" min="0"
                            value="{{ business_setting('best_deal_day') }}" class="w-full  p-1 " />
                        <x-labeled-input label="Hours" name="best_deal_hour" type="number" min="0"
                            value="{{ business_setting('best_deal_hour') }}" class="w-full  p-1 " />
                        <x-labeled-input label="Minutes" name="best_deal_minute" type="number" min="0"
                            value="{{ business_setting('best_deal_minute') }}" class="w-full  p-1 " />

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


    </div> --}}

    <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="w-full md:w-1/2 bg-white p-4">
                    {{-- <!-- Image Preview -->
                    <img width="120" height="50" id="prevImage" src="{{ business_image('best_deal_img') }}">

                    <!-- File Input -->
                    <x-labeled-input label="Image (580X365px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="best_deal_img" class="w-full p-1"
                        onchange="prevImage.src=window.URL.createObjectURL(this.files[0])" /> --}}

                    <!-- Title -->
                    <x-labeled-input label="Section Title" name="best_deal_title" type="text" class="w-full p-1"
                        value="{{ old('best_deal_title', business_setting('best_deal_title')) }}" />

                    <x-labeled-textarea name="best_deal_short_description" label="Short Description" :value="old('best_deal_short_description', business_setting('best_deal_short_description'))"
                        class="w-full p-1" />


                    <!-- Timer Inputs -->
                    <div class="w-full flex">
                        <x-labeled-input label="Day" name="best_deal_day" type="number" min="0"
                            class="w-full p-1" value="{{ old('best_deal_day', business_setting('best_deal_day')) }}" />
                        <x-labeled-input label="Hours" name="best_deal_hour" type="number" min="0"
                            class="w-full p-1"
                            value="{{ old('best_deal_hour', business_setting('best_deal_hour')) }}" />
                        <x-labeled-input label="Minutes" name="best_deal_minute" type="number" min="0"
                            class="w-full p-1"
                            value="{{ old('best_deal_minute', business_setting('best_deal_minute')) }}" />
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full pt-4 flex justify-end">
                        <x-button>
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-admin-app-layout>
