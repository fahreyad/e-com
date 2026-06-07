<x-admin-app-layout :title="__('Edit Variation')">

    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Edit Variation') }}</div>
    </div>

    <div class="flex items-center justify-between w-full space-x-5">
        <div class="w-full md:w-1/2 bg-white rounded  p-4">
            <form action="{{ route('admin.variation.update', $variation->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap w-full">
                    <x-labeled-input label="Variation Value" name="name" class="w-full p-1" value="{{ $variation->name }}" />

                    <div class="w-full mt-3">
                        <x-button>{{ __('Update') }}</x-button>
                    </div>
                </div>
            </form>
        </div>      
    </div>
</x-admin-app-layout>
