<x-admin-app-layout>

    <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-4">
                    <div class="flex flex-wrap w-full">
                        <div class="flex flex-wrap items-center w-full md:w-1/2">
                            <img width="50" height="50" id="prevMetaIcon" src="{{ business_image('meta_icon') }}">
                            <x-labeled-input label="Meta Icon (32x32px)" type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp" name="meta_icon"
                                class="w-full md:w-[89%] p-1"
                                onchange="prevMetaIcon.src=window.URL.createObjectURL(this.files[0])"
                                value="{{ business_setting('meta_icon') }}" />
                        </div>

                        <div class="flex flex-wrap items-center w-full md:w-1/2">
                            <img width="50" height="50" id="prevImage" src="{{ business_image('logo') }}">
                            <x-labeled-input label="Website Logo (80x80px)" type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp" name="logo"
                                class="w-full md:w-[89%] p-1"
                                onchange="prevImage.src=window.URL.createObjectURL(this.files[0])"
                                value="{{ business_setting('logo') }}" />
                        </div>

                        <x-labeled-input name="website_name" type="text"
                            value="{{ business_setting('website_name') }}" class="w-full md:w-1/2 p-1" />

                        <x-labeled-input name="email" type="text" value="{{ business_setting('email') }}"
                            class="w-full md:w-1/2 p-1 " />

                        <x-labeled-input name="phone" type="text" value="{{ business_setting('phone') }}"
                            class="w-full md:w-1/2  p-1 " />
                        <x-labeled-input name="whatsapp_number" type="text" value="{{ business_setting('whatsapp_number') }}"
                            class="w-full md:w-1/2  p-1 " />
                        <x-labeled-input label="Order Alert Number" name="alert_phone" type="text" pattern="^01\d{9}$" value="{{ business_setting('alert_phone') }}"
                                         class="w-full md:w-1/2  p-1 " />
                        <x-labeled-input name="messenger_link" type="text" value="{{ business_setting('messenger_link') }}"
                            class="w-full md:w-1/2  p-1 " />

                        <x-labeled-input name="address" type="text" value="{{ business_setting('address') }}"
                            class="w-full md:w-1/2  p-1 " />

                        <x-labeled-input name="invoice_prefix" type="text"
                            value="{{ business_setting('invoice_prefix') }}" class="w-full md:w-1/2  p-1 " />

                        <x-labeled-input name="copyright" type="text" value="{{ business_setting('copyright') }}"
                            class="w-full md:w-1/2  p-1 " />
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
