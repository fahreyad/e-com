<x-guest-layout>

    <div class="min-h-screen w-full bg-gradient-to-b from-green-300 to-green-700 flex flex-col">
        <div class="w-full p-4 flex justify-center border-b shadow bg-slate-400 bg-opacity-25 border-green-400">
            @auth
                <a href="{{ route('dashboard') }}"><x-button>Dashboard</x-button></a>
            @else
                <a href="{{ route('login') }}"><x-button>Login</x-button></a>
                <a href="{{ route('register') }}" class="ml-8"><x-button>Register</x-button></a>
                @endif
            </div>

            <div class="flex-grow flex justify-center items-center">
                <div
                    class="w-full max-w-[30rem] flex flex-col rounded-xl bg-slate-700 p-4 bg-opacity-25 backdrop-filter backdrop-blur-sm">
                    <div class="p-4 flex justify-center">
                        <x-application-logo class="w-32" />
                    </div>
                    <div class="w-full py-3 text-3xl text-center text-white">We are coming soon</div>
                </div>
            </div>
        </div>
    </x-guest-layout>
