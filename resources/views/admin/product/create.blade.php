<x-admin-app-layout :title="__('Create Product')">

    <div class="pb-3 flex justify-between">
        <div class="text-3xl">{{ __('Create Product') }}</div>
        <div>
            <a class="text-primary-700 underline font-semibold"
                href="{{ route('admin.product.index') }}">{{ __('Products') }}</a>
        </div>
    </div>


    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" x-data="productForm()"
        x-init="init()">
        @csrf

        <div class="bg-white p-4 rounded-xl shadow-md">

            <!-- Checkboxes -->
            <div class="mt-4 space-y-2 text-gray-700">
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="active_status" checked value="{{ \App\Enums\CommonStatus::Active }}"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="text-gray-700 ml-2">Is {{ \App\Enums\CommonStatus::Active()->description }}
                    </span>
                </label>

                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_variation"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                        value="{{ \App\Enums\ProductStatus::Variation }}" x-model="isVariation">
                    <span class="ml-2">Is {{ \App\Enums\ProductStatus::Variation()->description }}</span>
                </label>


                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_best_sale" value="{{ \App\Enums\ProductStatus::BestSale }}"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-2">Is {{ \App\Enums\ProductStatus::BestSale()->description }}</span>
                </label>

                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_hot_sale" value="{{ \App\Enums\ProductStatus::NewArrival }}"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <span class="ml-2">Is {{ \App\Enums\ProductStatus::NewArrival()->description }}</span>
                </label>
            </div>

            <!-- Preview Image -->
            <img width="50" id="prevImage" src="">

            <div class="flex flex-wrap w-full">
                <!-- Main Image Upload -->
                <x-labeled-input type="file" accept="image/*" label="Image(1000x1000px)" name="image"
                    class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" required
                    oninput="prevImage.src=window.URL.createObjectURL(this.files[0])" />

                <!-- Product Name -->
                <x-labeled-input name="name" required class="w-full p-1 md:w-1/2 lg:w-1/3"
                    input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                <!-- Category Dropdown -->
                <x-labeled-select label="Category" name="category_id" class="w-full p-1 md:w-1/2 lg:w-1/3">
                    <option class="font-semibold" value="" selected>Select Category</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                    @endforeach
                </x-labeled-select>
            </div>

            <!-- Regular Price & Offer Price -->
            <template x-if="!isVariation">
                <div class="flex flex-wrap w-full">

                    <x-labeled-input label="Weight Value" name="value" type="text" required
                        class="w-full p-1 md:w-1/2 lg:w-1/3"
                        input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                    <x-labeled-input name="regular_price" type="number" min="0" required
                        class="w-full p-1 md:w-1/2 lg:w-1/3"
                        input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />

                    <x-labeled-input label="Offer Price" name="sale_price" type="number" min="0"
                        class="w-full p-1 md:w-1/2 lg:w-1/3"
                        input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" />
                </div>
            </template>

            <!-- Dynamic Variation Section -->
            <div class="w-full border my-4 p-4 bg-gray-100 rounded" x-show="isVariation" x-cloak>
                <template x-for="(variation, index) in variations" :key="index">
                    <div class="w-full flex flex-wrap items-end gap-2 mb-3">
                        <!-- Variation Select -->
                        <div class="w-full sm:w-1/5">
                            <label class="block text-sm font-semibold mb-1">Variation*</label>
                            <select class="w-full bg-transparent border border-gray-300 text-gray-800 p-2 rounded"
                                :name="`variations[${index}][id]`" required>
                                <option value="">Select</option>
                                @foreach ($variations as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Value -->
                        <div class="w-full sm:w-1/5">
                            <label class="block text-sm font-semibold mb-1">Weight Value*</label>
                            <input type="text" required
                                class="w-full bg-transparent border border-gray-300 text-gray-800 p-2 rounded"
                                :name="`variations[${index}][variation_value]`" x-model="variation.variation_value" />
                        </div>

                        <!-- Regular Price -->
                        <div class="w-full sm:w-1/5">
                            <label class="block text-sm font-semibold mb-1">Regular Price*</label>
                            <input type="number" min="1" required
                                class="w-full bg-transparent border border-gray-300 text-gray-800 p-2 rounded"
                                :name="`variations[${index}][regular_price]`" x-model="variation.regular_price" />
                        </div>

                        <!-- Sale Price -->
                        <div class="w-full sm:w-1/5">
                            <label class="block text-sm font-semibold mb-1">Sale Price</label>
                            <input type="number" min="1"
                                class="w-full bg-transparent border border-gray-300 text-gray-800 p-2 rounded"
                                :name="`variations[${index}][sale_price]`" x-model="variation.sale_price" />
                        </div>

                        <!-- Remove Button -->
                        <div class="flex items-center h-full mt-6">
                            <button type="button" class="text-red-600 hover:text-red-800 px-3 py-1"
                                @click="removeVariation(index)">Remove</button>
                        </div>
                    </div>
                </template>

                <!-- Add More Button -->
                <div class="mt-2">
                    <x-button type="button" @click="addVariation()">+ Add Variation</x-button>
                </div>
            </div>

            <!-- Gallery Images Upload -->
            <x-labeled-input label="Gallery Images (1000x1000px)" type="file" accept="image/*"
                name="gallery_image[]" class="w-full p-1 mt-4"
                input-class="bg-transparent border border-gray-300 text-gray-800 placeholder-gray-500" multiple />

            <!-- Descriptions -->
            <x-labeled-textarea name="short_description" class="bg-transparent text-gray-800 placeholder-gray-500">
            </x-labeled-textarea>

            <x-labeled-textarea name="description" is-editor="is-editor"
                class="bg-transparent text-gray-800 placeholder-gray-500">
            </x-labeled-textarea>

            <!-- Submit -->
            <div class="w-full pt-4 flex justify-end">
                <x-button>{{ __('Create') }}</x-button>
            </div>
        </div>
    </form>

    <!-- Alpine.js logic -->
    <script>
        function productForm() {
            return {
                isVariation: false,
                variations: [],

                init() {
                    if (this.isVariation && this.variations.length === 0) {
                        this.addVariation();
                    }
                },

                addVariation() {
                    this.variations.push({
                        id: '',
                        variation_value: '',
                        regular_price: '',
                        sale_price: ''
                    });
                },

                removeVariation(index) {
                    this.variations.splice(index, 1);
                }
            };
        }
    </script>

</x-admin-app-layout>
