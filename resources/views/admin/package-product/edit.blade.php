<x-admin-app-layout :title="__('Edit Package Product')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Package Product') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.package-product.index') }}">{{ __('Package Products List') }}</a>
        </div>
    </div>


    <form action="{{ route('admin.package-product.update', $packageProduct->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white p-4 rounded-xl shadow-md">

            <!-- Preview Image -->
            <img width="50" id="prevImage" src="{{ asset($packageProduct->image) }}">

            <div class="flex flex-wrap w-full">
                <!-- Main Image Upload -->
                <x-labeled-input type="file" accept="image/*" label="Image (100X100px)" name="image"
                    class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500"
                    oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                <!-- Product Name -->
                <x-labeled-input name="name" required class="w-full p-1 md:w-1/2 lg:w-1/3"
                    value="{{ $packageProduct->name }}"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />
                <x-labeled-input label="Weight Value" name="value" type="text" required
                    value="{{ $packageProduct->value }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <x-labeled-input name="regular_price" type="number" min="1" required
                    value="{{ (int) $packageProduct->regular_price }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <x-labeled-input label="Offer Price" name="sale_price" type="number" min="1"
                    value="{{ (int) $packageProduct->sale_price }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />
            </div>

            <!-- Submit -->
            <div class="w-full pt-4 flex justify-end">
                <x-button>{{ __('Update') }}</x-button>
            </div>
        </div>
    </form>

</x-admin-app-layout>
