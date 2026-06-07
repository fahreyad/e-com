<x-admin-app-layout :title="__('Edit Slider')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Slider') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.slider.index') }}">{{ __('Sliders') }}</a>
        </div>
    </div>

    <div class="w-full md:w-2/5 md:pr-3">
        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white p-4">
                <img width="100" id="prevImage" src="{{ $slider->image }}">
                <div class="w-full">
                    <x-labeled-input label="Image (1400x450px)" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full p-1"
                        oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                    <x-labeled-input label="Page Link End Point (/products)" name="page_link"
                        value="{{ $slider->page_link }}" class="w-full p-1" />

                    <div class="w-full pt-4 flex justify-end">
                        <x-button>{{ __('Update') }}</x-button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</x-admin-app-layout>
