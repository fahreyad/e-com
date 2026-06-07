<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Products') }}</div>

        <div>
            <a href="{{ route('admin.product.create') }}"
                class="bg-transparent hover:bg-blue-500 text-blue-700 text-sm font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                + {{ __('Create Product') }}
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
                    <th>{{ __('Value') }}</th>
                    <th>{{ __('Regular Price') }}</th>
                    <th>{{ __('Sale Price') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Variation') }}</th>
                    <th>{{ __('Best Sale') }}</th>
                    <th>{{ __('Hot Sale') }}</th>
                    <th>{{ __('Active Status') }}</th>
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
                    url: '{{ route('admin.product.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {

                            item.action = actionIcons({
                                'edit': '{{ route('admin.product.edit', '@') }}'.replace('@', item
                                    .id),
                                'show': '{{ route('products.show', '@') }}'.replace('@',
                                    item.id),
                                'delete': '{{ route('admin.product.destroy', '@') }}'.replace('@',
                                    item.id),

                            });

                            item.image = `<img width="50" src='${item.image}' alt='${item.brand_name}'>`;

                            if (item.is_variation) {

                                const variations = item.product_variations;

                                if (Array.isArray(variations) && variations.length > 0) {
                                    const sorted = [...variations].sort(
                                        (a, b) => parseFloat(a.regular_price) - parseFloat(b.regular_price)
                                    );
                                    const minRePrice = sorted[0].regular_price;
                                    const maxRePrice = sorted[sorted.length - 1].regular_price;

                                    item.regular_price = parseFloat(minRePrice).toLocaleString() + 'TK - ' +
                                        parseFloat(maxRePrice).toLocaleString() + 'TK';

                                    if (item.sale_price) {

                                        const sortedSalePrice = [...variations].sort(
                                            (a, b) => parseFloat(a.sale_price) - parseFloat(b.sale_price)
                                        );
                                        const minSalePrice = sortedSalePrice[0].sale_price ?? 0;
                                        const maxSalePrice = sortedSalePrice[sortedSalePrice.length - 1]
                                            .sale_price ?? 0;

                                        item.sale_price = parseFloat(minSalePrice).toLocaleString() + 'TK - ' +
                                            parseFloat(maxSalePrice).toLocaleString() + 'TK';
                                    } else {
                                        item.sale_price = '0 TK';
                                    }

                                    const sortedValue = [...variations].sort(
                                        (a, b) => a.variation_value - b.variation_value
                                    );
                                    const minValue = sortedValue[0].variation_value;
                                    const maxValue = sortedValue[sortedValue.length - 1].variation_value;
                                    item.value = minValue + ' - ' + maxValue;


                                } else {
                                    // fallback if variations is empty
                                    item.regular_price = '0 TK';
                                    item.sale_price = '0 TK';
                                }

                            } else {
                                item.value = item.value;
                                item.regular_price = parseFloat(item.regular_price).toLocaleString() + 'TK';
                                item.sale_price = item.sale_price ? parseFloat(item.sale_price)
                                    .toLocaleString() + 'TK' : '0 TK';
                            }



                            // item.regular_price = Math.round(item.regular_price) + ' TK';
                            // item.sale_price = (Math.round(item.sale_price) ?? '0') + ' TK';

                            item.is_variation = item.is_variation ?
                                `<span class="text-green-500">Yes</span>` :
                                `<span class="text-red-500">No</span>`;
                            item.is_best_sale = item.is_best_sale ?
                                `<span class="text-green-500">Yes</span>` :
                                `<span class="text-red-500">No</span>`;

                            item.is_hot_sale = item.is_hot_sale ?
                                `<span class="text-green-500">Yes</span>` :
                                `<span class="text-red-500">No</span>`;

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
                        data: 'category.category_name'
                    },
                    {
                        data: 'is_variation'
                    },
                    {
                        data: 'is_best_sale'
                    },
                    {
                        data: 'is_hot_sale'
                    },
                    {
                        data: 'active_status'
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
