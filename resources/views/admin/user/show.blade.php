<x-admin-app-layout :title="__('User Details')">
    <div class="py-6 flex justify-between">
        <div class="text-3xl">{{ __('User Details') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
               href="{{ route('admin.user.index') }}">{{ __('Users') }}</a>
        </div>
    </div>

    <div class="w-full bg-white flex flex-wrap justify-end p-4">
        <div class="w-full md:w-1/2 lg:w-1/3 flex justify-center p-2">
            <img class="h-64 w-64" src="{{ $user->avatar }}" alt="Avatar of {{ $user->name }}"/>
        </div>
        <div class="w-full md:w-1/2 lg:w-2/3">
            <table>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Phone') }}</td>
                    <td class="p-2">{{ $user->phone }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Name') }}</td>
                    <td class="p-2">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Status') }}</td>
                    <td class="p-2">{{ $user->status->key }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Phone') }}</td>
                    <td class="p-2">{{ $user->phone }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Email') }}</td>
                    <td class="p-2">{{ $user->email }}</td>
                </tr>

                <tr>
                    <td class="p-2 font-semibold">{{ __('Address') }}</td>
                    <td class="p-2">{{ $user->address }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Fathers Name') }}</td>
                    <td class="p-2">{{ $user->fathers_name }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Mothers Name') }}</td>
                    <td class="p-2">{{ $user->mothers_name }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('NID Number') }}</td>
                    <td class="p-2">{{ $user->nid_number }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-semibold">{{ __('Share Amount') }}</td>
                    <td class="p-2">{{ \App\Lib\Wallets\WalletManager::get(\App\Enums\Wallet::CurrentWallet())->getBalanceFor($user) }}</td>
                </tr>

                <tr>
                    <td class="p-2 font-semibold">{{ __('Email Verified') }}</td>
                    <td class="p-2 flex">
                        @if($user->hasVerifiedEmail())
                            <div
                                    class="rounded bg-green-300 py-1 px-2 text-xs font-semibold text-green-800">{{ __('Yes') }}</div>
                        @else
                            <div
                                    class="rounded bg-red-200 py-1 px-2 text-xs font-semibold text-red-800">{{ __('No') }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="w-full bg-white my-8 flex flex-wrap justify-end p-4">
        <div class="w-full md:w-1/2  p-2">
            <div class="w-full text-lg text-center py-2">NID Front</div>
            <img class="h-64 w-64 border mx-auto" src="{{ $user->nid_front }}" alt="NID Front"/>
        </div>
        <div class="w-full md:w-1/2  p-2">
            <div class="w-full text-lg text-center py-2">NID Back</div>
            <img class="h-64 w-64 border mx-auto" src="{{ $user->nid_back }}" alt="NID Front"/>
        </div>
    </div>

</x-admin-app-layout>
