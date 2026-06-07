@props(['user' => null])

<div {{ $attributes->class(['flex w-full justify-center']) }} x-data="{ open: false }">
    @if($user)
        <div x-data="{ open: false }" x-on:mouseenter="open = true" x-on:mouseleave="open = false" class="relative">
            <!-- Trigger Element -->
            <div x-ref="toggle" class="relative">
                <img
                    src="{{ $user->avatar }}"
                    class="h-16 w-16 border-2 rounded-full
                {{ $user->status->is(\App\Enums\UserStatus::Active()) ? 'border-green-500' : 'border-red-500' }}"
                    alt=""
                />
            </div>

            <!-- Popover Content -->
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                x-anchor.top="$refs.toggle"
                class="mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-[200]"
            >
                <div class="p-4 text-left text-sm">
                    <div class="text">Name : {{ $user->name }}</div>
                    <div class="text">Username : {{ $user->username }}</div>
                    <div class="text">Left Carry : {{ $user->left_carry }}</div>
                    <div class="text">Right Carry : {{ $user->right_carry }}</div>
                </div>
            </div>
        </div>

    @else
        <div class="border size-16 rounded-full"></div>
    @endif
</div>
