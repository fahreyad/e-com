<x-admin-app-layout :title="__('Edit Delivery Charge')">

    <div class="w-full flex justify-between">
        <div class="text-xl">{{ __('Edit Delivery Charge') }}</div>
    </div>

    <div class="flex items-center justify-between w-full space-x-5">
        <div class="w-full md:w-1/2 bg-white rounded  p-4">
            <form action="{{ route('admin.delivery-charge.update', $deliveryCharge->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap w-full">
                    <x-labeled-input label="Delivery Area" name="area" class="w-full p-1"
                        value="{{ $deliveryCharge->area }}" />
                    <x-labeled-input label="Delivery Amount" name="amount" class="w-full p-1"
                        value="{{ (int) $deliveryCharge->amount }}" />

                    <div class="w-full mt-3">
                        <x-button>{{ __('Update') }}</x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-app-layout>
