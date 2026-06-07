<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin | {{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ business_image('meta_icon') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />

    <style>
        .isolate-css,
        .isolate-css::before,
        .isolate-css::after,
        .isolate-css *,
        .isolate-css *::before,
        .isolate-css *::after {
            all: revert;
        }

        .my_table tbody td {
            text-align: center;
            font-size: 14px;
        }

        .my_table tbody td img {
            margin: 0 auto;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body class="font-sans antialiased text-[0.8125rem]">
    <div class="flex min-h-screen bg-gray-200" x-data="{ sidebarOpen: window.innerWidth >= 1024, width: window.innerWidth }"
        x-on:resize.window="width = window.innerWidth; sidebarOpen = window.innerWidth >= 1024" x-init="$watch('sidebarOpen', value => document.querySelector('body').classList[value ? 'add' : 'remove']('overflow-hidden'))">
        <sidebar class="bg-[#f7f7f7] h-screen w-64 overflow-y-scroll scrollbar-hide fixed z-10 transition duration-300"
            :class="{ '-translate-x-64': !sidebarOpen }">
            <div class="p-4 md:pl-4 flex md:flex-row-reverse justify-center items-center flex-wrap">
                <x-application-logo class="h-24 mt-4 mb-4" />
            </div>

            {{-- @can('user-read')
                    <x-navigation-link :href="route('admin.user.index')" :text="__('User List')" />
                @endcan --}}

            <div class="w-full flex flex-col nav-links">

                <!-- Dashboard -->
                <x-navigation-link :href="route('admin.dashboard')" :text="__('Dashboard')"
                    icon='
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    ' />

                <!-- Branch -->
                <x-navigation-link :href="route('admin.branch.index')" :text="__('Branch List')"
                    icon='
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
</svg>
' />

                <!-- Package Products -->
                <x-navigation-link :href="route('admin.package-product.index')" :text="__('Package Products')"
                    icon='
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
</svg>
' />

                <!-- Products -->
                <x-navigation-link :text="__('Products')"
                    icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
</svg>
'>
                    <x-navigation-link :href="route('admin.product.create')" :text="__('Add Product')" />
                    <x-navigation-link :href="route('admin.product.index')" :text="__('All Product')" />
                    <x-navigation-link :href="route('admin.categories.index')" :text="__('Categories')" />
                    <x-navigation-link :href="route('admin.variation.index')" :text="__('Variation')" />
                </x-navigation-link>

                <!-- Orders -->
                <x-navigation-link :text="__('Orders')"
                    icon='
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
</svg>
'>
                    <x-navigation-link :href="route('admin.orders.index')" :text="__('All Orders')" />
                    @php
                        $branches = \App\Models\Admin\Branch::all();
                    @endphp
                    @foreach ($branches as $index => $item)
                        <x-navigation-link :href="route('admin.order.branch', [
                            'branch_name' => $item->name,
                            'branch_id' => $item->id,
                        ])" :text="__($item->name)" />
                    @endforeach

                </x-navigation-link>

                <!-- Corporate Orders -->
                <x-navigation-link :text="__('Corporate Orders')"
                    icon='
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
</svg>
'>

                    <x-navigation-link :href="route('admin.corporate-orders.index')" :text="__('All Orders')" />
                    @php
                        $branches = \App\Models\Admin\Branch::all();
                    @endphp
                    @foreach ($branches as $index => $item)
                        <x-navigation-link :href="route('admin.corporate-orders.branch', [
                            'branch_name' => $item->name,
                            'branch_id' => $item->id,
                        ])" :text="__($item->name)" />
                    @endforeach
                </x-navigation-link>
                <!-- Website Content -->
                <x-navigation-link :text="__('Website Content')"
                    icon='
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
</svg>
'>
                    <x-navigation-link :href="route('admin.notice.index')" :text="__('Notices')" />
                    <x-navigation-link :href="route('admin.slider.index')" :text="__('Sliders')" />
                    <x-navigation-link :href="route('admin.banner.index')" :text="__('Banner')" />
                    <x-navigation-link :href="route('admin.outlet-slider.index')" :text="__('Outlet Slider')" />
                    <x-navigation-link :href="route('admin.best-deals.index')" :text="__('Best Deals')" />
                </x-navigation-link>

                <!-- Settings -->
                <x-navigation-link :text="__('Settings')"
                    icon='
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
'>
                    <x-navigation-link :href="route('admin.delivery-charge.index')" :text="__('Delivery Charge')" />
                    <x-navigation-link :href="route('admin.generale-setting.index')" :text="__('General Setting')" />
                    <x-navigation-link :href="route('admin.social-links.index')" :text="__('Social Links')" />
                    <x-navigation-link :href="route('admin.pixel-setup.index')" :text="__('Pixel Setup')" />
                    <x-navigation-link :href="route('admin.password-update.create')" :text="__('Update password')" />
                </x-navigation-link>
            </div>
        </sidebar>

        <template x-if="sidebarOpen && width < 1024">
            <div>
                <div @click.slef="sidebarOpen = false"
                    class="absolute z-[1] top-0 bottom-0 right-0 left-0 bg-gray-500 opacity-50"></div>
            </div>
        </template>

        <div class="flex flex-col flex-grow w-full">
            <header class="w-full flex-grow-0">
                <div class="w-full flex justify-between items-center bg-white border-b border-gray-200 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="sidebarOpen = true"
                        class="h-6 w-6 cursor-pointer text-gray-600 lg:hidden" fill="currentColor" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <div class="flex-grow flex justify-end items-center gap-2">
                        <div class="h-5 ml-1 mr-2">
                            <a target="_blank" href="{{ route('home.index') }}" title="Website">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="#c11285">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
        10-4.48 10-10S17.52 2 12 2zM2 12h20M12 2c2.21 2.68 3.5 6.03
        3.5 10S14.21 17.32 12 20M12 2c-2.21 2.68-3.5 6.03
        -3.5 10S9.79 17.32 12 20" />
                                </svg>

                            </a>
                        </div>
                    </div>
                    <div class="relative" x-data="{ dropped: false }" x-on:click.outside="dropped = false">
                        <div class="flex items-center pl-2 mr-2 cursor-pointer" x-on:click="dropped = !dropped">

                            <div class="text-gray-500 font-semibold mx-1 ml-4">{{ auth()->user()->name }}</div>
                            <svg class="w-3 h-3 fill-current text-gray-400 ml-2" viewBox="0 0 12 12">
                                <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z"></path>
                            </svg>
                        </div>
                        <div class="w-48 fixed top-16 right-0 bg-white rounded-b shadow" x-show="dropped"
                            x-transition:enter="transition origin-top ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-y-0"
                            x-transition:enter-end="opacity-100 scale-y-100"
                            x-transition:leave="transition origin-top ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-y-100"
                            x-transition:leave-end="opacity-0 scale-y-0">
                            <div class="p-2 cursor-pointer hover:font-semibold">
                                <a href="{{ route('admin.profile-update.create') }}">
                                    {{ __('Profile') }}
                                </a>
                            </div>
                            <div class="p-2 cursor-pointer hover:font-semibold">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <div onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-grow lg:ml-64">
                @if (isset($header) && $header)
                    <div class="p-4 bg-white">
                        {{ $header ?? '' }}
                    </div>
                @endif
                @if (session(\App\Mixin\ResponseMixin::SUCCESS_MESSAGE_SESSION_KEY))
                    <x-alert
                        type="success">{{ session(\App\Mixin\ResponseMixin::SUCCESS_MESSAGE_SESSION_KEY) }}</x-alert>
                @endif
                @if (session(\App\Mixin\ResponseMixin::ERROR_MESSAGE_SESSION_KEY))
                    <x-alert
                        type="error">{{ session(\App\Mixin\ResponseMixin::ERROR_MESSAGE_SESSION_KEY) }}</x-alert>
                @endif
                <div class="p-4">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>


    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript">
        window.onload = () => {
            const url = location.href.indexOf('?') > 0 ?
                location.href.substring(0, location.href.indexOf('?')) :
                location.href;
            document.querySelector('.nav-links').querySelectorAll("a").forEach(element => {
                if (element.href === url) {
                    element.classList.add('active')
                }
            })
            document.querySelectorAll("a.active").forEach(element => {
                element.classList.remove('border-transparent')
                element.classList.add('border-teal-400')
                element.dispatchEvent(
                    new CustomEvent("active", {
                        bubbles: true,
                    })
                );
            });
        };
    </script>



    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace(document.querySelector('[is-editor="is-editor"]'));
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof CKEDITOR !== 'undefined') {
                // Find the instance of CKEditor and set the configuration
                for (var instance in CKEDITOR.instances) {
                    if (CKEDITOR.instances.hasOwnProperty(instance)) {
                        CKEDITOR.instances[instance].config.versionCheck = false;
                    }
                }
            }
        });
    </script>
    {{ $script ?? '' }}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#username-select').select2({
                placeholder: 'Select or search a username',
                allowClear: true,
                width: 'resolve'
            });
        });
    </script>
</body>

</html>
