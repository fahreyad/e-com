{{-- Mobile Menu --}}
@php
    $cartItems = session()->get('cart', []);
    $subtotal = 0;

    $allCategories = \App\Models\Admin\Category::query();
    $categories = $allCategories->where('active_status', \App\Enums\CommonStatus::Active())->get();
    $navbarCategories = $allCategories->where('active_status', \App\Enums\CommonStatus::Active())->take(7)->get();

    $branches = \App\Models\Admin\Branch::all();

    $branch = session()->get('branch', []);

@endphp

{{-- Mobile View Bottom --}}
<div x-data="{ searchModalMobileOpen: false }">
    <section>
        <div
            class="md:hidden  mobile-menu fixed z-50 bottom-6 left-1/2 -translate-x-1/2 w-[95%] shadow-xl rounded-xl bg-white py-3 px-4">
            <ul class="flex justify-between items-center">
                <li>
                    <a href="{{ route('home.index') }}">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}">
                        <i class="fa-solid fa-box"></i>
                    </a>
                </li>

                <li class="flex items-center">
                    <!-- Search Button -->
                    <button @click="searchModalMobileOpen = true" class="text-xl text-gray-700">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </li>
                <!-- Search Modal Mobile Wrapper -->






                @if (Auth::user())
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </section>

    <div>
        <!-- Overlay -->
        <div x-show="searchModalMobileOpen" x-transition.opacity @click="searchModalMobileOpen = false"
            class="fixed top-0 inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>

        <!-- Modal Box -->
        <div x-show="searchModalMobileOpen" x-transition class="fixed inset-x-0 top-[10%] flex justify-center z-50 px-4"
            x-cloak>
            <div @click.away="searchModalMobileOpen = false"
                class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xl space-y-6 border border-gray-100">

                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b pb-3">
                    <h2 class="text-xl font-bold text-gray-800">Search</h2>
                    <button @click="searchModalMobileOpen = false" class="text-red-500 hover:text-red-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <form action="{{ route('search.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <input type="text" name="query"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400"
                        placeholder="Type to search..." required>

                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-[#eb8ba1] text-white font-semibold rounded-lg hover:bg-pink-600 transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<section>
    <div id="topNavbar">
        <!-- Top Bar Section Start -->
        <div id="topBarSection" class="top_bar_section">
            <div class="container mx-auto hidden md:block">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="left_site pt-4">
                        <ul class="menus flex gap-6">
                            <li class="flex items-center">
                                <img class="w-[24px] h-[24px]"
                                    src="{{ asset('front-end/assets/images/icons/font-icon/loation.png') }}"
                                    alt="">
                                Your
                                Location
                            </li>

                            <li class="flex items-center">
                                <img class="w-[24px] h-[24px]"
                                    src="{{ asset('front-end/assets/images/icons/font-icon/store.png') }}"
                                    alt="">

                                <form action="{{ route('branch-select') }}" method="POST">
                                    @csrf
                                    <select name="branch_id" class="p-1 rounded border-0 w-[180px]"
                                        onchange="this.form.submit()">
                                        <option value="" disabled {{ empty($branch) ? 'selected' : '' }}>Select
                                            Branch</option>
                                        @if (!empty($branches))
                                            @foreach ($branches as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ !empty($branch) && $item->id == $branch['id'] ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </form>

                            </li>
                        </ul>
                    </div>
                    <div class="center">
                        <div class="w-[60px] h-[60px]">
                            <a href="{{ route('home.index') }}">
                                <x-application-logo class="w-full h-full"></x-application-logo>
                            </a>
                        </div>
                    </div>
                    <div class="right_site pt-4">
                        <ul class="menus flex gap-2">
                            <li class="flex items-center" x-data="{ searchModalOpen: false }">
                                <!-- Search Button (Triggers Modal) -->
                                <button @click="searchModalOpen = true">
                                    <img class="w-[24px] h-[24px]"
                                        src="{{ asset('front-end/assets/images/icons/font-icon/search.png') }}"
                                        alt="">
                                </button>

                                <!-- Search Modal -->
                                <!-- Overlay -->
                                <div x-show="searchModalOpen" x-transition.opacity @click="searchModalOpen = false"
                                    class="fixed inset-0 bg-black bg-opacity-50 z-40" x-cloak></div>

                                <!-- Modal Box -->
                                <div x-show="searchModalOpen" x-transition
                                    class="fixed inset-x-0 top-[10%] flex justify-center z-50" x-cloak>
                                    <div @click.away="searchModalOpen = false"
                                        class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-xl mx-4 space-y-6 border border-gray-100">

                                        <!-- Modal Header -->
                                        <div class="flex items-center justify-between border-b pb-3">
                                            <h2 class="text-xl font-bold text-gray-800">Search</h2>
                                            <button @click="searchModalOpen = false"
                                                class="text-red-500 hover:text-red-700 transition">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Modal Content -->
                                        <form action="{{ route('search.index') }}" method="GET"
                                            class="flex flex-col sm:flex-row">
                                            <input type="text" name="query"
                                                class="flex-1 px-4 py-3 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400"
                                                placeholder="Type to search..." required>

                                            <button type="submit"
                                                class="px-6 py-3 bg-[#eb8ba1] text-white font-semibold transition">
                                                Search
                                            </button>
                                        </form>
                                    </div>
                                </div>


                            </li>

                            @if (business_setting('email'))
                                <li class="flex items-center">
                                    <a href="tel:{{ business_setting('phone') }}">
                                        <img class="w-[24px] h-[24px] inline"
                                            src="{{ asset('front-end/assets/images/icons/font-icon/call.png') }}"
                                            alt="">
                                        {{ business_setting('phone') }}</a>
                                </li>
                            @endif

                            <!-- Cart Dropdown -->
                            <div class="relative group" id="cart-dropdown-wrapper">
                                <button onclick="toggleDropdown('desktop-cart')"
                                    class="hidden md:flex items-center font-bold text-gray-700 hover:text-blue-600 relative">
                                    <img class="w-[24px] h-[24px]"
                                        src="{{ asset('front-end/assets/images/icons/font-icon/shoping-cart.png') }}"
                                        alt="">
                                    <span class="ml-1 bg-red-500 text-white text-xs px-2 rounded-full">
                                        {{ count($cartItems) }}
                                    </span>
                                </button>
                                <div id="dropdown-desktop-cart"
                                    class="absolute right-0 hidden transition-all duration-300 opacity-0 scale-y-95 transform origin-top bg-white shadow-lg w-80 z-20 rounded-md p-4 space-y-4 text-sm">

                                    @if (count($cartItems) > 0)
                                        <div class="space-y-2 max-h-60 overflow-y-auto">
                                            @foreach ($cartItems as $index => $item)
                                                <div class="flex items-center justify-between cart-item"
                                                    data-index="{{ $index }}">
                                                    <img src="{{ $item['image'] }}" class="w-10 h-10 rounded"
                                                        alt="image">
                                                    <div class="flex-1 ml-3">
                                                        <h4 class="font-bold text-gray-700">{{ $item['name'] }}</h4>
                                                        <div class="flex items-center space-x-2">
                                                            <button
                                                                class="qty-btn px-2 py-1 bg-gray-200 rounded text-sm"
                                                                data-action="decrease"
                                                                data-index="{{ $index }}">-</button>
                                                            <span
                                                                class="quantity text-gray-800">{{ $item['quantity'] }}</span>
                                                            <button
                                                                class="qty-btn px-2 py-1 bg-gray-200 rounded text-sm"
                                                                data-action="increase"
                                                                data-index="{{ $index }}">+</button>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="font-semibold text-gray-700 total-price">
                                                            ৳
                                                            {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                        </p>
                                                        <form action="{{ route('cart.product-remove', $index) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Remove this product?')">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit"
                                                                class="text-red-600 hover:underline text-xs">Remove</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                                            @endforeach
                                        </div>
                                        <div class="border-t pt-2">
                                            <p class="text-center font-semibold">Subtotal: <span class="subtotal"> ৳
                                                    {{ number_format($subtotal, 2) }}</span></p>
                                        </div>
                                        <div class="flex justify-between space-x-2">
                                            <a href="{{ route('view-cart.index') }}"
                                                class="w-1/2 text-center py-2 bg-gray-200 rounded hover:bg-gray-300 font-bold">View
                                                Cart</a>
                                            <a href="{{ route('checkout.index') }}"
                                                class="w-1/2 text-center py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Checkout</a>
                                        </div>
                                    @else
                                        <div class="max-w-xl mx-auto text-center py-8">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="mx-auto w-16 text-gray-400 mb-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7H18m-6-7v7" />
                                            </svg>
                                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty
                                            </h2>
                                            <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.
                                            </p>
                                            <a href="{{ route('products.index') }}"
                                                class="inline-block px-6 py-2 bg-[#eb8ba1] text-white rounded-md font-medium hover:bg-blue-700 transition">Start
                                                Shopping</a>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            @if (Auth::user())
                                <li class="flex items-center">
                                    <a class="flex" href="{{ route('dashboard') }}">
                                        {{ Auth::user()->name }} <img class="w-[24px] h-[24px]"
                                            src="{{ asset('front-end/assets/images/icons/font-icon/user.png') }}"
                                            alt="">
                                    </a>
                                </li>
                            @else
                                <li class="flex items-center">
                                    <a href="{{ route('login') }}">
                                        <img class="w-[24px] h-[24px]"
                                            src="{{ asset('front-end/assets/images/icons/font-icon/user.png') }}"
                                            alt="">
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="md:hidden">
                <div class="flex items-center justify-between mx-5">
                    {{-- Mobile Menu --}}
                    <div x-data="{ menuOpen: false }" class="relative">
                        <!-- Toggle Button -->
                        <button @click="menuOpen = true" class="p-2">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Overlay -->
                        <div x-show="menuOpen" x-transition.opacity @click="menuOpen = false"
                            class="fixed inset-0 bg-black bg-opacity-50 z-30" x-cloak></div>

                        <!-- Off-Canvas Menu (LEFT SIDE) -->
                        <div x-show="menuOpen" x-transition:enter="transition transform duration-300"
                            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transition transform duration-300"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-40 p-4 overflow-y-auto" x-cloak>

                            <!-- Close Button -->
                            <button @click="menuOpen = false" class="mb-4 w-full flex justify-end">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Menu Items -->
                            <ul class="flex flex-col space-y-2">
                                <!-- Dropdown: All Categories -->
                                <li x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="flex justify-between w-full text-left text-gray-700 hover:text-blue-600">
                                        All Categories
                                        <svg class="w-4 h-4 transform" :class="{ 'rotate-180': open }"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.14.976l-4.25 4.65a.75.75 0 01-1.1 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <ul x-show="open" x-cloak class="mt-2 space-y-1 pl-4">
                                        @foreach ($categories as $item)
                                            <li>
                                                <a href="{{ route('category.show', $item->slug) }}"
                                                    class="block text-sm text-gray-700 hover:text-blue-600">
                                                    {{ $item->category_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <!-- Static Category Links -->
                                @foreach ($navbarCategories as $item)
                                    <li>
                                        <a href="{{ route('category.show', $item->slug) }}"
                                            class="text-gray-700 hover:text-blue-600 block">
                                            {{ $item->category_name }}
                                        </a>
                                    </li>
                                @endforeach

                                <!-- Corporate Order -->
                                <li>
                                    <a href="{{ route('corporate-order.index') }}"
                                        class="flex items-center text-gray-700 hover:text-blue-600 gap-2">
                                        <img class="w-5 h-5"
                                            src="{{ asset('front-end/assets/images/icons/font-icon/arrow-icon.png') }}"
                                            alt="">
                                        Corporate Order
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="center">
                        <div class="w-[50px] h-[50px] md:w-[80px] md:h-[80px]">
                            <a href="{{ route('home.index') }}">
                                <x-application-logo class="w-full h-full"></x-application-logo>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button id="mobile-cart" class="flex">
                            <img class="w-[24px] h-[24px]"
                                src="{{ asset('front-end/assets/images/icons/font-icon/shoping-cart.png') }}"
                                alt="">
                            <span class="bg-red-500 text-white text-xs px-2 rounded-full">
                                {{ count($cartItems) }}
                            </span>
                        </button>
                    </div>
                </div>
                <div id="offcanvas-cart"
                    class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-50 p-4 pt-16">

                    <!-- Header -->
                    <div class="absolute top-3 left-4 right-12 flex items-center justify-between">
                        <h2 class="text-xl font-semibold">Your Cart</h2>
                        <button id="close-cart"
                            class="text-red-600 hover:text-black text-2xl font-bold focus:outline-none">
                            &times;
                        </button>
                    </div>

                    @if (count($cartItems) > 0)
                        <!-- Scrollable Product List -->
                        <div class="overflow-y-auto pb-40 h-full space-y-2">
                            @foreach ($cartItems as $index => $item)
                                <div class="flex items-center justify-between cart-item"
                                    data-index="{{ $index }}">
                                    <img src="{{ $item['image'] }}" class="w-10 h-10 rounded" alt="image">
                                    <div class="flex-1 ml-3">
                                        <h4 class="font-bold text-gray-700">{{ $item['name'] }}</h4>
                                        <div class="flex items-center space-x-2">
                                            <button class="qty-btn px-2 py-1 bg-gray-200 rounded text-sm"
                                                data-action="decrease" data-index="{{ $index }}">-</button>
                                            <span class="quantity text-gray-800">{{ $item['quantity'] }}</span>
                                            <button class="qty-btn px-2 py-1 bg-gray-200 rounded text-sm"
                                                data-action="increase" data-index="{{ $index }}">+</button>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-700 total-price">
                                            TK {{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </p>
                                        <form action="{{ route('cart.product-remove', $index) }}" method="POST"
                                            onsubmit="return confirm('Remove this product?')">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                class="text-red-600 hover:underline text-xs">Remove</button>
                                        </form>
                                    </div>
                                </div>
                                @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            @endforeach
                        </div>

                        <!-- Fixed Footer -->
                        <div class="absolute bottom-0 left-0 w-full px-4 pb-4 bg-white border-t pt-3">
                            <p class="text-center font-semibold">Subtotal:
                                <span class="subtotal">TK {{ number_format($subtotal, 2) }}</span>
                            </p>
                            <div class="flex justify-between space-x-2 mt-3">
                                <a href="{{ route('view-cart.index') }}"
                                    class="w-1/2 text-center py-2 bg-gray-200 rounded hover:bg-gray-300 font-bold">View
                                    Cart</a>
                                <a href="{{ route('checkout.index') }}"
                                    class="w-1/2 text-center py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Checkout</a>
                            </div>
                        </div>
                    @else
                        <!-- Empty Cart UI -->
                        <div class="h-full flex flex-col justify-center items-center text-center px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-16 text-gray-400 mb-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7H18m-6-7v7" />
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
                            <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-block px-6 py-2 bg-[#eb8ba1] text-white rounded-md font-medium hover:bg-blue-700 transition">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>


                <script>
                    const cartBtn = document.getElementById('mobile-cart');
                    const cartPanel = document.getElementById('offcanvas-cart');
                    const closeCartBtn = document.getElementById('close-cart');

                    cartBtn.addEventListener('click', () => {
                        cartPanel.classList.toggle('translate-x-full');
                    });

                    closeCartBtn.addEventListener('click', () => {
                        cartPanel.classList.add('translate-x-full');
                    });

                    // Optional: Close on outside click
                    document.addEventListener('click', function(e) {
                        if (!cartPanel.contains(e.target) && !cartBtn.contains(e.target)) {
                            cartPanel.classList.add('translate-x-full');
                        }
                    });
                </script>

            </div>
        </div>
        <!-- Top Bar Section End -->

        <!-- Navbar Section Start  -->
        <div id="navBarSection" class="nav_bar_section bg-white hidden md:block" x-data="{ mobileMenuOpen: false }">
            <nav class="container mx-auto">
                <!-- Menu Section -->
                <div class="md:flex items-center justify-between">
                    <ul class="flex flex-col md:flex-row md:items-center md:justify-between w-full">
                        <!-- Dropdown: Savouries -->
                        <li class="p-2 relative group" x-data="{ open: false }">
                            <div class="flex items-center justify-between md:block">
                                <a href="javascript:void(0)" class="text-gray-700 hover:text-blue-600"
                                    @click.prevent="open = !open">All Categories</a>
                                <!-- Dropdown icon -->
                                <button @click.prevent="open = !open" class="ml-2">
                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.14.976l-4.25 4.65a.75.75 0 01-1.1 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown Items -->
                            <ul x-show="open" x-cloak x-transition
                                class="md:absolute md:top-full md:left-0 md:mt-2 bg-white md:shadow-md rounded-md w-full md:w-48 z-20 space-y-1 md:space-y-0 md:py-2 md:block hidden group-hover:block">
                                @foreach ($categories as $index => $item)
                                    <li>
                                        <a href="{{ route('category.show', $item->slug) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ $item->category_name }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </li>

                        <!-- Simple links -->
                        @foreach ($navbarCategories as $index => $item)
                            <li class="p-2">
                                <a href="{{ route('category.show', $item->slug) }}"
                                    class="text-gray-700 hover:text-blue-600 block">
                                    {{ $item->category_name }}</a>
                            </li>
                        @endforeach


                        <li class="p-2">
                            <a href="{{ route('corporate-order.index') }}"
                                class="flex items-center text-gray-700 hover:text-blue-600 gap-2">
                                <img class="w-5 h-5"
                                    src="{{ asset('front-end/assets/images/icons/font-icon/arrow-icon.png') }}"
                                    alt="">
                                Corporate Order
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Navbar Section End  -->
    </div>

    @php
        $notices = \App\Models\Admin\Notice::where('status', \App\Enums\CommonStatus::Active())->latest()->get();
    @endphp

    <!-- Text Animation Section Start -->
    <div class="text_animation overflow-hidden whitespace-nowrap text-white py-1 md:py-2">
        <ul class="scrolling_text flex text-md md:text-lg font-medium">
            @if ($notices->count() > 0)
                @foreach ($notices as $index => $notice)
                    <li>{{ $notice->title }}</li>
                @endforeach
            @else
                <li>{{ __('Welcome To Misthi Kotha') }}</li>
            @endif
        </ul>
    </div>
    <!-- Text Animation Section End -->


    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(`dropdown-${id}`);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                dropdown.classList.toggle('opacity-0');
                dropdown.classList.toggle('scale-y-95');
            }
        }

        document.addEventListener('click', function(e) {
            const cartDropdown = document.getElementById('dropdown-desktop-cart');
            const cartWrapper = document.getElementById('cart-dropdown-wrapper');
            if (cartDropdown && !cartWrapper.contains(e.target)) {
                cartDropdown.classList.add('hidden', 'opacity-0', 'scale-y-95');
            }
        });


        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('topNavbar');
            if (window.scrollY > 0) {
                navbar.classList.add('fixed');
            } else {
                navbar.classList.remove('fixed');
            }
        });
    </script>

</section>
