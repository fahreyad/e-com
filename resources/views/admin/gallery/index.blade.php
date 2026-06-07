<x-admin-app-layout>

    @php
        $gallery = $gallery ?? null;
    @endphp
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ $gallery ? __('Edit Galleries') : __('Galleries') }}</div>


        @if ($gallery)
            <div>
                <a href="{{ route('admin.gallery.index') }}"
                    class="bg-transparent hover:bg-blue-500 text-blue-700 text-sm font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    + {{ __('Create Gallery') }}
                </a>
            </div>
        @endif

    </div>

    <div class="flex flex-wrap justify-between mt-4">

        <div class="w-full md:w-2/5 md:pe-4">
            <form action="{{ $gallery ? route('admin.gallery.update', $gallery->id) : route('admin.gallery.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($gallery)
                    @method('PUT')
                @endif

                <div class="bg-white p-4">
                    <img width="50" id="prevImage" src="{{ $gallery->image ?? '' }}">
                    <div class="w-full">
                        @if ($gallery == null)
                            <x-labeled-input label="Image (300x280px)" type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full p-1"
                                required onchange="prevImage.src=window.URL.createObjectURL(this.files[0])" />
                        @else
                            <x-labeled-input label="Image (300x280px)" type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp" name="image" class="w-full p-1"
                                onchange="prevImage.src=window.URL.createObjectURL(this.files[0])" />
                        @endif


                        {{-- <x-labeled-input name="serial" type="number" min="1"
                            value="{{ $gallery->serial ?? '' }}" class="w-full p-1 " /> --}}


                        <div class="w-full pt-4 flex justify-end">
                            <x-button>
                                {{ $gallery ? __('Update') : __('Create') }}
                            </x-button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="w-full md:w-3/5">
            <table class="w-full my_table" id="gallery-table">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('SL') }}</th>
                        <th>{{ __('Image') }}</th>
                        {{-- <th>{{ __('Serial') }}</th> --}}
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#gallery-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.gallery.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.gallery.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.gallery.destroy', '@') }}'.replace('@',
                                    item.id),
                            });

                            item.image = `<img width="50" src='${item.image}' alt='${item.name}'>`;

                            return item;
                        });
                        return response.data;
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        orderable: false,
                    },
                    // {
                    //     data: 'serial',
                    //     searchable: false
                    // },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        </script>
    </x-slot>
</x-admin-app-layout>
