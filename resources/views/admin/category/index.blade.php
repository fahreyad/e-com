<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Categories') }}</div>

        <div>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-transparent hover:bg-blue-500 text-blue-700 text-sm font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                + {{ __('Create Category') }}
            </a>
        </div>

    </div>


    <div class="w-full mt-8">
        <table class="w-full my_table" id="categories-table">
            <thead class="text-center">
                <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th>{{ __('Banner Image') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Active Status') }}</th>
                    <th>{{ __('Serial') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#categories-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.categories.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.categories.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.categories.destroy', '@') }}'.replace('@',
                                    item.id),
                            });

                            item.image = `<img width="50" src='${item.image}' alt='${item.category_name}'>`;
                            item.banner_image =
                                `<img width="50" src='${item.banner_image}' alt='${item.category_name}'>`;


                            // console.log(item.sup_category[0].category_name);
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
                        data: 'category_name'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'banner_image'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'active_status'
                    },
                    {
                        data: 'serial'
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
