<x-guest-layout title="Corporate Order">

    @include('front-end.corporate-order.banner')
    {{-- Page Main Content Section  --}}
    <section id="corporateOrderPage" class="corporate-order-page py-6 md:py-16">
        <div class="w-full md:w-3/4 mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="section_title text-2xl font-semibold mb-4 text-gray-800">Customize Order</h2>

            <form action="{{ route('corporate-order-details.store') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}">

                <x-labeled-input label="Contact Person Name" name="contact_name" required="true" class="w-full"
                    value="{{ Auth::user()->name ?? '' }}" />
                <x-labeled-input label="Company Name" name="company_name" class="w-full" />

                <x-labeled-input label="Company Phone Number" name="company_phone" type="tel" required="true"
                    class="w-full" value="{{ Auth::user()->phone ?? '' }}" />
                <x-labeled-input label="Designation" name="designation" class="w-full" />

                <div class="w-full">
                    <x-labeled-input label="Email ID" name="email" type="email" required="true" class="w-full"
                        value="{{ Auth::user()->email ?? '' }}" />
                    <p class="section_title text-[14px]">Note: All communications regarding the corporate order will be
                        sent to this
                        mail ID</p>
                </div>

                <x-labeled-select label="Select Branch" name="branch_id" required="true" class="w-full">
                    <option value="" disabled {{ empty($branch) ? 'selected' : '' }}>Select
                        Branch</option>
                    @if (!empty(\App\Models\Admin\Branch::all()))
                        @foreach (\App\Models\Admin\Branch::all() as $item)
                            <option value="{{ $item->id }}"
                                {{ !empty($branch) && $item->id == $branch['id'] ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    @endif
                </x-labeled-select>

                <x-labeled-textarea label="Address" name="address" rows="3" class="w-full"
                    value="{{ Auth::user()->address ?? '' }}" />
                <x-labeled-textarea label="Note" name="note" rows="3" class="w-full" />

                <!-- Next Button -->
                <div class="text-end pt-4">
                    <button type="submit" class="px-8 py-2 bg-[#ffac46] rounded-full text-white font-semibold">
                        Next
                    </button>
                </div>
            </form>

        </div>

    </section>
</x-guest-layout>
