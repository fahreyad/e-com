<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Package Products') }}</div>

        <div>
            <a href="{{ route('admin.package-product.create') }}"
                class="bg-transparent hover:bg-blue-500 text-blue-700 text-sm font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                + {{ __('Create Package Product') }}
            </a>
        </div>
    </div>

    <div class="w-full mt-8">
        <table class="w-full my_table" id="products-table">
            <thead class="text-center">
                <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Weight') }}</th>
                    <th>{{ __('Regular Price') }}</th>
                    <th>{{ __('Sale Price') }}</th>                   
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#products-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.package-product.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {

                            item.action = actionIcons({
                                'edit': '{{ route('admin.package-product.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.package-product.destroy', '@') }}'.replace('@',
                                    item.id),
                            });

                            item.image = `<img width="50" src='${item.image}' alt='${item.brand_name}'>`;
                          

                            item.regular_price = parseFloat(item.regular_price).toLocaleString() + 'TK'
                            item.sale_price = item.sale_price ? parseFloat(item.sale_price).toLocaleString() + 'TK': "0TK"

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
                        data: 'image'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'value'
                    },
                    {
                        data: 'regular_price'
                    },
                    {
                        data: 'sale_price'
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
