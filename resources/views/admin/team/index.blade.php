<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Teams') }}</div>

        <div>
            <a href="{{ route('admin.team.create') }}"
                class="bg-transparent hover:bg-blue-500 text-blue-700 text-sm font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                + {{ __('Create Team') }}
            </a>
        </div>

    </div>


    <div class="w-full mt-8">
        <table class="w-full my_table" id="teams-table">
            <thead class="text-center">
                <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Image') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Designation') }}</th>
                    <th>{{ __('FB') }}</th>
                    <th>{{ __('YouTube') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#teams-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.team.index') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            item.action = actionIcons({
                                'edit': '{{ route('admin.team.edit', '@') }}'.replace('@', item
                                    .id),
                                'delete': '{{ route('admin.team.destroy', '@') }}'.replace('@',
                                    item.id),
                            });

                            item.image = `<img width="50" src='${item.image}' alt='${item.name}'>`;

                            return item;
                        });
                        return response.data;
                    }
                },

                columns: [{
                        data: 'serial',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'image',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        orderable: false,
                    },
                    {
                        data: 'designation',
                        orderable: false,
                    },
                    {
                        data: 'fb_link',
                        orderable: false,
                    },
                    {
                        data: 'youtube_link',
                        orderable: false,
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
