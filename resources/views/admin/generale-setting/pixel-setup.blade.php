<x-admin-app-layout>

    <div class="flex flex-wrap justify-between mt-4">
        <div class="w-full">
            <form action="{{ route('admin.business-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-4">
                    <x-labeled-textarea name="pixel_setup" type="text" value="{{ business_setting('pixel_setup') }}"
                        class="w-full h-full p-1" placeholder="only script code here ..." />

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
