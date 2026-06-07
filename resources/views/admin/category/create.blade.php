<x-admin-app-layout :title="__('Create Category')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Create Category') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a>
        </div>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white p-4">
            <div class="flex flex-wrap w-full">

                <div class="w-full p-1 md:w-1/2">
                    <img width="50" id="prevImage" src="">
                    <x-labeled-input label="Image (300x300px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full" required
                        oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                </div>
                <div class="w-full p-1 md:w-1/2">
                    <img width="80" id="bannerPrevImage" src="">
                    <x-labeled-input label="Banner Image (1400x400px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="banner_image" class="w-full"
                        oninput="bannerPrevImage.src=window.URL.createObjectURL(this.files[0])" required="true" />
                </div>
                <x-labeled-input name="category_name" required="true" value="{{ old('category_name') }}" class="w-full p-1 md:w-1/3" />
                <x-labeled-input name="serial" type="number" min="0" value="{{ old('serial') }}" class="w-full p-1 md:w-1/3" />

                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="status" value="{{ \App\Enums\CategoryStatus::PopularCategory }}"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-gray-700 ml-2">Is
                        {{ \App\Enums\CategoryStatus::PopularCategory()->description }}</span>
                </label>

                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="active_status" checked value="{{ \App\Enums\CommonStatus::Active }}"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-gray-700 ml-2">Is {{ \App\Enums\CommonStatus::Active()->description }}
                        Category</span>
                </label>
                <div>
                    @foreach (\App\Enums\CategoryPosition::getInstances() as $index => $item)
                        
                        <label class="inline-flex items-center mt-2">
                            <input type="radio" name="home_page_position" value="{{ $item->value }}"
                                class="h-5 w-5 text-blue-600 rounded-full border-gray-300 focus:ring-blue-500">
                            <span class="text-gray-700 ml-2">Is {{ $item->description }}</span>
                        </label>
                    @endforeach
                </div>






                <div class="w-full pt-4 flex justify-end">
                    <x-button>{{ __('Create') }}</x-button>
                </div>
            </div>
        </div>

    </form>
</x-admin-app-layout>
