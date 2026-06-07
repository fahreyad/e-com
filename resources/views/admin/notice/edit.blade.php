<x-admin-app-layout :title="__('Edit Notice')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Edit Notice') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.notice.index') }}">{{ __('Notice') }}</a>
        </div>
    </div>

    <div class="w-full md:w-2/5 md:pr-3">
        <form action="{{ route('admin.notice.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white p-4">
                <div class="w-full">
                    <x-labeled-input label="Notice Title" name="title" value="{!! $notice->title !!}"
                        class="w-full p-1" />

                    <x-labeled-select name="status">
                        @foreach (\App\Enums\CommonStatus::toSelectArray() as $key => $item)
                            <option value="{{ $key }}" {{ $key == $notice->status->value ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </x-labeled-select>

                    <div class="w-full pt-4 flex justify-end">
                        <x-button>{{ __('Update') }}</x-button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</x-admin-app-layout>
