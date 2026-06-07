<x-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Orders') }}</div>

    </div>


    <div class="w-full mt-8">
        <table class="w-full my_table" id="order-table">
            <thead class="text-center">
                <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Branch Name') }}</th>
                    <th>{{ __('Order Number') }}</th>
                    <th>{{ __('Order Date') }}</th>
                    <th>{{ __('Delivery Charge') }}</th>
                    <th>{{ __('Total Amount') }}</th>
                    <th>{{ __('Payment Method') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#order-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('delivered-orders.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {

                            item.action = actionIcons({
                                'show': '{{ route('my-orders.show', '@') }}'.replace('@', item
                                    .id),

                                // 'edit': '{{ route('admin.product.edit', '@') }}'.replace('@', item
                                //     .id),
                                // 'delete': '{{ route('admin.product.destroy', '@') }}'.replace('@',
                                //     item.id),
                            });

                            const date = new Date(item.order_date);
                            const day = date.getDate();
                            const month = date.toLocaleString('en-US', {
                                month: 'short'
                            }); // Mar
                            const year = date.getFullYear();

                            item.order_date = `${day} ${month} ${year}`;
                            item.delivery_amount = parseFloat(item.delivery_amount).toLocaleString() + 'TK'
                            item.total_amount = parseFloat(item.total_amount).toLocaleString() + 'TK'
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
                        data: 'branch.name'
                    },
                    {
                        data: 'order_number'
                    },
                    {
                        data: 'order_date'
                    },

                    {
                        data: 'delivery_amount'
                    },
                    {
                        data: 'total_amount'
                    },

                    {
                        data: 'payment_method'
                    },
                    {
                        data: 'status'
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
</x-app-layout>
