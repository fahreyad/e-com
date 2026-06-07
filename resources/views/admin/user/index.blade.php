<x-admin-app-layout>
    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Users') }}</div>
    </div>
    <div class="w-full mt-8">
        <table class="w-full" id="users-table">
            <thead>
                <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Email') }}</th>                                  
                    <th>{{ __('Created At') }}</th>                   
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <x-slot name="script">
        <script type="text/javascript" src="{{ mix('js/datatable.js') }}"></script>
        <script type="text/javascript">
            $('#users-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route('admin.user.index') }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}',
                    dataSrc(response) {
                        response.data.map(function(item) {
                            let actionConfig = {
                                'show': '{{ route('admin.user.show', '@') }}'.replace('@', item.id),
                                @can('user-update')
                                    'portal': '{{ route('admin.user.portal', '@') }}'.replace('@', item
                                        .id),
                                    // 'edit': '{{ route('admin.user.edit', '@') }}'.replace('@', item.id),
                                @endcan
                                @can('user-delete')
                                    // 'delete': '{{ route('admin.user.destroy', '@') }}'.replace('@', item
                                    //     .id),
                                @endcan
                            }
                            item.created_at = (new Date(item.created_at)).toLocaleDateString();
                      

                            item.action = actionIcons(actionConfig);                      
                    

                           
                            return item;
                        });
                        return response.data;
                    }
                },
                // dom:
                //     "<'flex flex-wrap'<'w-full flex justify-center my-1 sm:justify-end sm:w-1/2'f>>" +
                //     "<'flex my-4'<'w-full overflow-y-auto'tr>>" +
                //     "<'flex flex-wrap'<'w-full my-2 sm:w-1/3'i><'w-full sm:w-2/3 text-right'p>>",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },                 
                   
                    {
                        data: 'created_at'
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
