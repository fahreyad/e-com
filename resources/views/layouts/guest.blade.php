<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- @props(['title' => business_setting('website_name') ?? config('app.name', 'Laravel')]) --}}

    <title>{{ $title . ' | ' . business_setting('website_name') }}</title>

    <link rel="shortcut icon" href="{{ business_image('meta_icon') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{ $style ?? '' }}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.tailwindcss.com/3.2.4"></script>
    <!-- Alpine.js CDN -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    @livewireStyles

    <!-- pixel_setup code -->
    <script src="{{ business_setting('pixel_setup') }}"></script>

</head>

<body>

    <!-- Floating Button Menu -->
    <div x-data="{ open: false }" class="fixed bottom-28 md:bottom-16 right-6 z-50 flex flex-col items-end space-y-3">
        <!-- Messenger -->
        <a title="Messenger"
            href="{{ business_setting('messenger_link') ? business_setting('messenger_link') : 'javascript:void(0)' }}"
            @if (business_setting('messenger_link')) target="_blank" @endif x-show="open"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            class="flex items-center bg-blue-600 text-white p-2 rounded-full shadow-lg">
            <i class="fab fa-facebook-messenger"></i>
        </a>

        <!-- Call -->
        <a title="Call"
            href="{{ business_setting('phone') ? 'tel:' . business_setting('phone') : 'javascript:void(0)' }}"
            x-show="open" x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="flex items-center bg-green-600 text-white p-2 rounded-full shadow-lg">
            <i class="fas fa-phone"></i>
        </a>

        <!-- WhatsApp -->
        <a title="WhatsApp"
            href="{{ business_setting('whatsapp_number') ? 'https://wa.me/' . business_setting('whatsapp_number') : 'javascript:void(0)' }}"
            @if (business_setting('whatsapp_number')) target="_blank" @endif x-show="open"
            x-transition:enter="transition ease-out duration-300 delay-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="flex items-center bg-green-500 text-white p-2 rounded-full shadow-lg">
            <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Toggle Button -->
        <button title="Live Chat" @click="open = !open"
            class="bg-gray-800 hover:bg-gray-700 text-white px-2 py-1 rounded-full shadow-lg focus:outline-none">
            <template x-if="open">
                <i class="fas fa-times"></i>
            </template>
            <template x-if="!open">
                <i class="fas fa-comment-dots"></i>
            </template>
        </button>
    </div>

    <!-- Scroll to Top Button -->
    <button title="Go To Top" x-data="{ showTopBtn: false }" x-init="window.addEventListener('scroll', () => { showTopBtn = window.scrollY > 300 })" x-show="showTopBtn" x-transition
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-20 md:bottom-6 right-6 z-50 bg-[#f6b9c3] p-1.5 text-white rounded-full shadow-lg"
        aria-label="Scroll to top">
        <!-- Heroicon: chevron-up -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>



    @if (request()->getPathInfo() != '/login')
        {{-- Navbar Section Start  --}}
        @include('layouts.navbar')
        {{-- Navbar Section End  --}}
    @endif


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast({!! json_encode(session('success')) !!}, 'success');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast({!! json_encode(session('error')) !!}, 'error');
            });
        </script>
    @endif
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast({!! json_encode(session('warning')) !!}, 'warning');
            });
        </script>
    @endif

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    @if (request()->getPathInfo() != '/login')
        {{-- Footer Section Start  --}}
        <x-footer></x-footer>
        {{-- Footer Section End  --}}
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('front-end/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('front-end/assets/js/script.js') }}"></script>

    <script>
        function showToast(message, type = 'success') {
            let bgColor = '#4CAF50'; // default green

            if (type === 'error') bgColor = '#F44336'; // red
            else if (type === 'warning') bgColor = '#FF9800'; // orange

            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: bgColor,
                stopOnFocus: true,
                style: {
                    color: "#fff"
                }
            }).showToast();
        }
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('.qty-btn').click(function() {
                const button = $(this);
                const action = button.data('action');
                const id = button.data('index');
                const parent = button.closest('.cart-item');

                $.ajax({
                    url: '{{ route('cart.updateQuantity') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action, // btn increase or decrease
                        id: id
                    },
                    success: function(res) {
                        parent.find('.quantity').text(res.quantity);
                        parent.find('.total-price').text('৳ ' + res.total);
                        $('.subtotal').text('৳ ' + res.subtotal);
                        // ✅ Update grand total based on selected delivery                       
                    },
                    error: function() {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('.qty-btn').click(function() {
                const button = $(this);
                const action = button.data('action');
                const id = button.data('index');
                const parent = button.closest('.cart-item');

                $.ajax({
                    url: '{{ route('cart.updateQuantity') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action,
                        id: id
                    },
                    success: function(res) {
                        parent.find('.quantity').text(res.quantity);
                        parent.find('.total-price').text('৳ ' + res.total);
                        $('.subtotal').text('৳ ' + res.subtotal);

                        // ✅ Call updateTotals after quantity update
                        const selectedDelivery = document.querySelector(
                            '.delivery-radio:checked');
                        if (selectedDelivery && typeof updateTotals === 'function') {
                            updateTotals(selectedDelivery.dataset.amount);
                        }
                    },
                    error: function() {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.qtyBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productContainer = this.closest('.product_info');
                    if (!productContainer) return;

                    const qtyInputs = productContainer.querySelectorAll('.qty-input');
                    let value = parseInt(qtyInputs[0].value) || 1;

                    if (this.dataset.action === 'increaseBtn') {
                        value++;
                    } else if (this.dataset.action === 'decreaseBtn' && value > 1) {
                        value--;
                    }

                    qtyInputs.forEach(input => {
                        input.value = value;
                    });
                });
            });

            // Sync variation select with hidden inputs in forms
            document.querySelectorAll('.product_info').forEach(container => {
                const productId = container.dataset.productId;
                const variationSelect = container.querySelector(`#variation_select_${productId}`);

                if (variationSelect) {
                    const buyNowVariationInput = container.querySelector(`#buyNow_variation_${productId}`);
                    const addToCartVariationInput = container.querySelector(
                        `#addToCart_variation_${productId}`);

                    // Initialize hidden inputs on page load
                    buyNowVariationInput.value = variationSelect.value;
                    addToCartVariationInput.value = variationSelect.value;

                    // On change update hidden inputs
                    variationSelect.addEventListener('change', () => {
                        buyNowVariationInput.value = variationSelect.value;
                        addToCartVariationInput.value = variationSelect.value;
                    });
                }
            });
        });
    </script>

    @livewireScripts

    {{ $script ?? '' }}
</body>

</html>
