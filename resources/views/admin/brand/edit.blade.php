<x-admin-app-layout :title="__('Edit Brand')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Brand') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.brand.index') }}">{{ __('Brands') }}</a>
        </div>
    </div>

    <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white p-4">
            <img width="50" id="prevImage" src="{{ $brand->image }}">
            <div class=" w-full">
                <x-labeled-input type="file" accept="image/jpeg,image/png,image/jpg,image/webp" name="image"
                    class="w-full p-1 md:w-1/2 lg:w-1/3"
                    oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />
                <x-labeled-input name="brand_name" value="{{ $brand->brand_name }}"
                    class="w-full p-1 md:w-1/2 lg:w-1/3" />

                <div class="w-full pt-4 flex justify-end">
                    <x-button>{{ __('Update') }}</x-button>
                </div>
            </div>
        </div>

    </form>
</x-admin-app-layout>
