<x-admin-app-layout :title="__('Create Team')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Create Team') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.team.index') }}">{{ __('Teams') }}</a>
        </div>
    </div>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white p-4">
            <img width="50" id="prevImage" src="">
            <div class="flex flex-wrap justify-center w-full">
                <x-labeled-input label="Image (300x280px)" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" name="image"
                    class="w-full p-1 md:w-1/2 lg:w-1/3" required
                    oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />
                <x-labeled-input name="serial" type="number" min="1" required class="w-full p-1 md:w-1/2 lg:w-1/3" />
                <x-labeled-input name="name" required class="w-full p-1 md:w-1/2 lg:w-1/3" />
                <x-labeled-input name="designation" required class="w-full p-1 md:w-1/2 lg:w-1/3" />            
                <x-labeled-input name="fb_link" class="w-full p-1 md:w-1/2 lg:w-1/3" />            
               
                <x-labeled-input name="youtube_link" class="w-full p-1 md:w-1/2 lg:w-1/3" />            
        

                <div class="w-full pt-4 flex justify-end">
                    <x-button>{{ __('Create') }}</x-button>
                </div>
            </div>
        </div>

    </form>
</x-admin-app-layout>
