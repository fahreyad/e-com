<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Outlet Sliders') }}</div>
    </div>

    <div class="flex flex-wrap justify-between">


        <div class="w-full md:w-2/5 md:pr-3">
            <form action="{{ route('admin.outlet-slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white p-4">
                    <img width="100" id="prevImage" src="">
                    <div class="w-full">
                        <x-labeled-input label="Image (690x450px)" type="file"
                            accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full p-1"
                            required oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                        <x-labeled-input label="Page Link End Point (/products)" name="page_link" class="w-full p-1" />

                        <div class="w-full pt-4 flex justify-end">
                            <x-button>{{ __('Create') }}</x-button>
                        </div>
                    </div>
                </div>

            </form>
        </div>


        <div class="w-full 
         @if ($outletSliders) md:w-3/5 @endif
        md:pl-3">
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase text-center">
                    <tr>
                        <th class="px-4 py-3">SL</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Page Link</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center text-sm divide-y divide-gray-100">
                    @forelse ($outletSliders as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-center">
                                <img src="{{ $item->image }}" alt="Slider Image {{ $index + 1 }}"
                                    class="w-12 h-auto mx-auto rounded-md border border-gray-300 object-cover shadow-sm">
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ $item->page_link }}" target="_blank"
                                    class="text-blue-600 hover:underline truncate block max-w-xs mx-auto">
                                    {{ $item->page_link }}
                                </a>
                            </td>

                            <td class="px-4 py-2 flex items-center justify-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.outlet-slider.edit', $item->id) }}"
                                    class="px-2 py-1 text-sm font-medium rounded-lg 
              bg-blue-500 text-white border
              hover:bg-blue-600  transition">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.outlet-slider.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this outlet slider?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-sm font-medium rounded-lg 
                       bg-red-500 text-white hover:bg-red-600  transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-gray-500 italic">
                                No slider data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>


</x-admin-app-layout>
