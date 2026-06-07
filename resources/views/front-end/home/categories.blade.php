 <section class="category_section py-12 md:py-[60px] bg-white">
            <div class="container mx-auto px-4">

                <!-- Section Title -->
                <div class="section_title text-center mb-12">
                    <h2
                        class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-transparent bg-clip-text relative inline-block">
                        Categories
                        <span
                            class="block mt-2 w-24 h-1 bg-pink-500 mx-auto rounded-full shadow-md shadow-pink-400"></span>
                    </h2>
                </div>

                <!-- Category Grid -->
                <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 xl:grid-cols-9 gap-6">

                    <!-- Category Item -->
                    @foreach ($categories as $i => $item)
                        <div class="category-item text-center group transition-transform duration-300 hover:scale-105"
                            title="{{ $item->category_name }}">
                            <div class="img-box w-24 h-24 mx-auto rounded-full overflow-hidden shadow-md">
                                <img class="w-full h-full object-cover" src="{{ $item->image }}"
                                    alt="{{ $item->category_name }}">
                            </div>
                            <div class="category-info mt-3">
                                <h4 class="text-gray-800 font-semibold text-sm group-hover:text-indigo-600 transition">
                                    {{ $item->category_name }}</h4>
                                {{-- <p class="text-xs text-gray-500">50+ items</p> --}}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>