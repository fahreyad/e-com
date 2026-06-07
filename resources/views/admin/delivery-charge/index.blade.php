<x-admin-app-layout title="Delivery Charge">
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Delivery Charge') }}</div>
    </div>

    <div class="flex items-center justify-between w-full space-x-5">
        <div class="w-full md:w-1/2 bg-white rounded  p-4">
            <form action="{{ route('admin.delivery-charge.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-wrap w-full">
                    <x-labeled-input label="Delivery Area" name="area" class="w-full p-1" required="true" />
                    <x-labeled-input label="Delivery Amount" type="number" min="0" name="amount"
                        class="w-full p-1" required="true" />

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
                        <th>{{ __('Delivery Area') }}</th>
                        <th>{{ __('Delivery Amount') }}</th>
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
                    url: '{{ route('admin.delivery-charge.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.delivery-charge.edit', '@') }}'.replace('@',
                                    item
                                    .id),
                                'delete': '{{ route('admin.delivery-charge.destroy', '@') }}'.replace(
                                    '@',
                                    item.id),
                            });

                            item.amount = parseFloat(item.amount).toLocaleString() + ' TK'

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
                        data: 'area'
                    },
                    {
                        data: 'amount'
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
