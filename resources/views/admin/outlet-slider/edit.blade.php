<x-admin-app-layout :title="__('Edit Outlet Slider')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Outlet Slider') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.outlet-slider.index') }}">{{ __('Outlet Sliders') }}</a>
        </div>
    </div>

    <div class="w-full md:w-2/5 md:pr-3">
        <form action="{{ route('admin.outlet-slider.update', $outletSlider->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white p-4">
                <img width="100" id="prevImage" src="{{ $outletSlider->image }}">
                <div class="w-full">
                    <x-labeled-input label="Image (690x450px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full p-1"
                        oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                    <x-labeled-input label="Page Link End Point (/products)" name="page_link"
                        value="{{ $outletSlider->page_link }}" class="w-full p-1" />

                    <div class="w-full pt-4 flex justify-end">
                        <x-button>{{ __('Update') }}</x-button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</x-admin-app-layout>
