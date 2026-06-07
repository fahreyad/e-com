<x-admin-app-layout>

    <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <x-labeled-input name="fb_link" type="text" value="{{ business_setting('fb_link') }}"
                            class="w-full p-1" />
                        <x-labeled-input name="twitter_link" type="text"
                            value="{{ business_setting('twitter_link') }}" class="w-full p-1" />

                        <x-labeled-input name="instagram_link" type="text"
                            value="{{ business_setting('instagram_link') }}" class="w-full p-1" />

                        <x-labeled-input name="youtube_link" type="text"
                            value="{{ business_setting('youtube_link') }}" class="w-full p-1" />

                        <x-labeled-input name="tiktok_link" type="text" value="{{ business_setting('tiktok_link') }}"
                            class="w-full p-1" />

                        <x-labeled-input name="pinterest_link" type="text"
                            value="{{ business_setting('pinterest_link') }}" class="w-full p-1" />
                    </div>

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
