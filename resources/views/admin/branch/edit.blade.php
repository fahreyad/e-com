<x-admin-app-layout :title="__('Edit Branch')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Branch') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.branch.index') }}">{{ __('Branch List') }}</a>
        </div>
    </div>


    <form action="{{ route('admin.branch.update', $branch->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white p-4 rounded-xl shadow-md">           
            <div class="flex flex-wrap w-full">              
           
                <x-labeled-input name="name" required class="w-full p-1 md:w-1/2 lg:w-1/3"
                    value="{{ $branch->name }}"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <x-labeled-input name="email" type="email" required
                    value="{{ $branch->email }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <x-labeled-input name="phone" type="text" required
                    value="{{ $branch->phone }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <x-labeled-textarea label="Location *" name="location" type="text" required
                    value="{{ $branch->location }}" class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />
               
            </div>

            <!-- Submit -->
            <div class="w-full pt-4 flex justify-end">
                <x-button>{{ __('Update') }}</x-button>
            </div>
        </div>
    </form>

</x-admin-app-layout>
