<x-guest-layout>

    @if (count($galleries) > 0)
        <!-- Gallery Section Start -->
        <section class="gallery_section py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="section_title text-center mb-12">
                    <h2
                        class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-transparent bg-clip-text relative inline-block">
                        Our Gallery
                        <span
                            class="block mt-2 w-24 h-1 bg-pink-500 mx-auto rounded-full shadow-md shadow-pink-400"></span>
                    </h2>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($galleries as $item)
                        <div
                            class="relative group rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div class="aspect-w-1 aspect-h-1">
                                <img src="{{ asset($item->image) }}" alt="Gallery Image"
                                    class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-300" />
                            </div>

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10l4.553-4.553a.75.75 0 00-1.06-1.06L14 8.939m0 0L9.447 4.386a.75.75 0 10-1.06 1.06L12 10m0 0l-4.553 4.553a.75.75 0 101.06 1.06L14 11.061m0 0l4.553 4.553a.75.75 0 101.06-1.06L15 10z" />
                                </svg>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500">No gallery items found.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $galleries->links('pagination::tailwind') }}
                </div>
            </div>
        </section>
        <!-- Gallery Section End -->
    @endif


</x-guest-layout>
