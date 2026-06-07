 <!-- Hero Section Start -->
 <section id="heroSection" class="hero_section">
     @if ($sliders->isNotEmpty())
         @foreach ($sliders as $index => $slider)
             <div class="img_box ">
                 <a href="{{ $slider->page_link ?? 'javascript:void(0)' }}">
                     <img class="w-full h-full" src="{{ $slider->image }}" alt="">
                 </a>
             </div>
         @endforeach
     @else
         <div class="img_box">
             <img class="w-full h-full" src="{{ asset('front-end/assets/images/banner-img/hero-image.png') }}"
                 alt="">
         </div>
     @endif

 </section>
 <!-- Hero Section End -->
