<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full flex flex-wrap">
        @foreach ($cards as $card)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3">
                {{-- <div class="rounded-2xl w-full bg-gradient-to-br from-[#c11285] via-[#e54c6c] to-[#e97f44] text-white shadow-xl hover:shadow-2xl transition-shadow duration-300"> --}}
                <div class="rounded-2xl w-full bg-[#c11285] shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="text-sm uppercase tracking-wider font-semibold text-white">
                            {{ $card->title }}
                        </div>
                        <div class="text-4xl font-extrabold mt-3 text-right text-[#e97f44]">
                            {{ $card->value }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-admin-app-layout>
