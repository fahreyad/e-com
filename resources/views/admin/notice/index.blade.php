<x-admin-app-layout title="__('Notices')">
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Notices') }}</div>
    </div>

    <div class="flex flex-wrap justify-between">
        <div class="w-full md:w-2/5 md:pr-3">
            <form action="{{ route('admin.notice.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white p-4">
                    <div class="w-full">
                        <x-labeled-input label="Notice Title" name="title" class="w-full p-1" required="true" />

                        <x-labeled-select name="status">
                            @foreach (\App\Enums\CommonStatus::toSelectArray() as $key => $item)
                                <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </x-labeled-select>

                        <div class="w-full pt-4 flex justify-end">
                            <x-button>{{ __('Create') }}</x-button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

        <div class="w-full md:w-3/5 md:pl-3">
            <table class="w-full my_table" id="categories-table">
                <thead class="text-center">
                    <tr>
                        <th>{{ __('SL') }}</th>
                        <th>{{ __('Notice Title') }}</th>
                        <th>{{ __('Status') }}</th>
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
                    url: '{{ route('admin.notice.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.notice.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.notice.destroy', '@') }}'.replace('@',
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
                        data: 'title'
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
</x-admin-app-layout>
