<div class="container mx-auto px-4 md:px-0 pt-5 {{ $attributes['class'] }}">
    <nav class="text-gray-600 text-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Home</a>
                <i class="fas fa-angle-right mx-2 text-gray-400"></i>
            </li>
            @php
                $segments = explode('/', request()->path());
            @endphp
            @foreach ($segments as $index => $segment)
                @php
                    $url = url(implode('/', array_slice($segments, 0, $index + 1)));
                @endphp
                <li class="flex items-center">
                    @if ($loop->last)
                        <span class="text-gray-500 capitalize">{{ str_replace('-', ' ', $segment) }}</span>
                    @else
                        <a href="{{ $url }}" class="text-blue-600 hover:underline capitalize">
                            {{ str_replace('-', ' ', $segment) }}
                        </a>
                        <i class="fas fa-angle-right mx-2 text-gray-400"></i>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>


</div>
