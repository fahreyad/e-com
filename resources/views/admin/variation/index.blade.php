<x-admin-app-layout title="Variation List">
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Variation') }}</div>
    </div>

    <div class="flex items-center justify-between w-full space-x-5">
        <div class="w-full md:w-1/2 bg-white rounded  p-4">
            <form action="{{ route('admin.variation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-wrap w-full">
                    <x-labeled-input label="Variation Value" name="name" class="w-full p-1" required="true" />

                    <div class="w-full mt-3">
                        <x-button>{{ __('Create') }}</x-button>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full md:w-1/2 mt-8">
            <table class="w-full my_table" id="categories-table">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('SL') }}</th>
                        <th>{{ __('Variation Value') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#categories-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.variation.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.variation.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.variation.destroy', '@') }}'.replace('@',
                                    item.id),
                            });

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
                        data: 'name'
                    },

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
