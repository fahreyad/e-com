  <!-- Footer All Section Start -->
  <footer id="footerSection" class="footer_section">
      <!-- Subscriber Section Start -->
      <div class="subscriber_section px-3 md:px-0">
          <div class="container mx-auto py-5">
              <div class="flex flex-wrap items-center justify-between">
                  <div class="">
                      <h2 class="title-2 text-white">With Love, From Mishti Kotha</h2>
                      <p class="common_text_2 text-white">Subscribe to our newsletter for Mishti Kotha offers.</p>
                  </div>
                  <div>
                      <form action="#">
                          <input class="border-0 rounded-tl-lg rounded-bl-lg w-[70%] py-3" type="email"
                              placeholder="Enter Your Email" required>
                          <button class="py-3 px-10 bg-[#FAAE43] text-white ml-[-3px]"><i
                                  class="fa-solid fa-arrow-right"></i></button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <!-- Subscriber Section End -->

      <!-- Shipping Info Section Start -->
      <div class="shipping_section bg-[#F9F9F9] px-3 md:px-0">
          <div class="container mx-auto py-8">
              <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-10">
                  <div class="flex items-center">
                      <div class="img_box mr-3">
                          <img class="w-[60px] h-[60px]"
                              src="{{ asset('front-end/assets/images/icons/footer-icon/f-icon-1.png') }}"
                              alt="">
                      </div>
                      <div class="info">
                          <h5 class="title-7 mb-1 ">SHIPPING</h5>
                          <p class="common_text_3">Only Dhaka</p>
                      </div>
                  </div>
                  <div class="flex items-center">
                      <div class="img_box mr-3">
                          <img class="w-[60px] h-[60px]"
                              src="{{ asset('front-end/assets/images/icons/footer-icon/f-icon-2.png') }}"
                              alt="">
                      </div>
                      <div class="info">
                          <h5 class="title-7 mb-1 ">ONLINE PAYMENT</h5>
                          <p class="common_text_3">Payment methods</p>
                      </div>
                  </div>
                  <div class="flex items-center">
                      <div class="img_box mr-3">
                          <img class="w-[60px] h-[60px]"
                              src="{{ asset('front-end/assets/images/icons/footer-icon/f-icon-3.png') }}"
                              alt="">
                      </div>
                      <div class="info">
                          <h5 class="title-7 mb-1 ">SUPPORT</h5>
                          <p class="common_text_3">10AM to 8PM</p>
                      </div>
                  </div>
                  <div class="flex items-center">
                      <div class="img_box mr-3">
                          <img class="w-[60px] h-[60px]"
                              src="{{ asset('front-end/assets/images/icons/footer-icon/f-icon-4.png') }}"
                              alt="">
                      </div>
                      <div class="info">
                          <h5 class="title-7 mb-1 ">SECURE</h5>
                          <p class="common_text_3">Payments</p>
                      </div>
                  </div>
                  <div class="flex items-center">
                      <div class="img_box mr-3">
                          <img class="w-[60px] h-[60px]"
                              src="{{ asset('front-end/assets/images/icons/footer-icon/f-icon-5.png') }}"
                              alt="">
                      </div>
                      <div class="info">
                          <h5 class="title-7 mb-1">FESTIVAL</h5>
                          <p class="common_text_3">Gifts</p>
                      </div>
                  </div>
              </div>

          </div>
      </div>
      <!-- Shipping Info Section End -->

      <!-- Footer Main Section Start -->
      <div class="footer_main_section">
          <div class="bg-[#9b9b9be6] px-5 md:px-0 pt-10 pb-5">
              <div class="container mx-auto">
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                      <div class="footer_about">
                          <div class="img_box">
                              <a href="{{ route('home.index') }}">
                                  <x-application-logo></x-application-logo>
                              </a>
                          </div>
                          <ul>
                              @if (business_setting('address'))
                                  <li>
                                      <a href="javascript:void(0)">
                                          <i class="fa-solid fa-location-arrow"></i>
                                          {{ business_setting('address') }}</a>
                                  </li>
                              @endif
                              @if (business_setting('phone'))
                                  <li>
                                      <a href="tel:{{ business_setting('phone') }}">
                                          <i class="fa-solid fa-mobile-screen-button"></i>
                                          {{ business_setting('phone') }}
                                      </a>
                                  </li>
                              @endif
                              @if (business_setting('email'))
                                  <li>
                                      <a href="mailto:{{ business_setting('email') }}">
                                          <i class="fa-regular fa-envelope"></i>
                                          {{ business_setting('email') }} </a>
                                  </li>
                              @endif

                          </ul>
                          <div class="social_links mt-3">
                              <ul class="flex space-x-3">
                                  @if (business_setting('fb_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('fb_link') }}">
                                              <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-1.png') }}"
                                                  alt="">
                                          </a>
                                      </li>
                                  @endif
                                  @if (business_setting('twitter_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('twitter_link') }}">
                                              <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-2.png') }}"
                                                  alt="">
                                          </a>
                                      </li>
                                  @endif
                                  @if (business_setting('instagram_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('instagram_link') }}">
                                              <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-3.png') }}"
                                                  alt="">
                                          </a>
                                      </li>
                                  @endif
                                  @if (business_setting('youtube_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('youtube_link') }}">
                                              <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-4.png') }}"
                                                  alt="">
                                          </a>
                                      </li>
                                  @endif
                                  @if (business_setting('pinterest_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('pinterest_link') }}">
                                              <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-5.png') }}"
                                                  alt="">
                                          </a>
                                      </li>
                                  @endif
                                  @if (business_setting('tiktok_link'))
                                      <li>
                                          <a target="_blank" href="{{ business_setting('tiktok_link') }}">
                                              {{-- <img class="w-[30px] h-[30px]"
                                                  src="{{ asset('front-end/assets/images/icons/social-icon/social-icon-5.png') }}"
                                                  alt=""> --}}
                                              <p class="w-[30px] h-[30px] bg-black rounded-full text-center pt-1.5"><i
                                                      class="fa-brands fa-tiktok text-[14px]"></i></p>
                                          </a>
                                      </li>
                                  @endif

                              </ul>
                          </div>
                      </div>
                      <div class="footer_menu">
                          <h5 class="title-5">Quick Links</h5>
                          <ul>
                              <li> <a href="{{ route('home.index') }}">Home</a> </li>
                              <li> <a href="javascript:void(0)">About Us</a> </li>
                              <li> <a href="{{ route('products.index') }}">Products</a> </li>
                              <li> <a href="javascript:void(0)">Blogs</a> </li>
                              <li> <a href="javascript:void(0)">Contact Us</a> </li>
                          </ul>
                      </div>
                      @php
                          $allCategories = \App\Models\Admin\Category::query();
                          $categories = $allCategories->take(5)->get();

                      @endphp
                      <div class="footer_menu">
                          <h5 class="title-5">Categories</h5>
                          @if (count($categories) > 0)
                              <ul>
                                  @foreach ($categories as $index => $item)
                                      <li>
                                          <a href="{{ route('category.show', $item->slug) }}">
                                              {{ $item->category_name }}
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                      </div>
                      <div class="footer_menu">
                          <h5 class="title-5">For Customers</h5>
                          <ul>
                              <li> <a href="javascript:void(0)">Important Links</a> </li>
                              <li> <a href="javascript:void(0)">FAQ</a> </li>
                              <li> <a href="javascript:void(0)">Privacy Policy</a> </li>
                              <li> <a href="javascript:void(0)">Return & Refund Policy</a> </li>
                              <li> <a href="javascript:void(0)">Terms And Conditions</a> </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Footer Main Section End -->

      <!-- Footer Bottom Section Start -->
      <div class="footer_bottom_section py-2">
          <div class="container mx-auto">
              <div class="md:flex items-center justify-between text-center text-md-left">
                  <p class="common_text_3">© Copyright of Mishti Kotha 2025 Powered by Ocado Technology</p>
                  {{-- <p class="common_text_3">Development By <a class="text-blue-600" target="_blank"
                          href="https://easyitsolutionltd.com/">Easy IT Solution LTD</a></p> --}}
                  <p class="common_text_3">Concern of Gawsia Agro Ltd.</p>
              </div>
          </div>
      </div>
      <!-- Footer Bottom Section End -->
  </footer>
  <!-- Footer All Section End -->
