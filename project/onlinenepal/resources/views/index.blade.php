@extends('layouts.app')
@section('website-content')
    <main>
        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>
                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                "autoplay": {
                    "delay": 5000
                },
                "slidesPerView": 8,
                "slidesPerGroup": 1,
                "effect": "none",
                "loop": true,
                "navigation": {
                    "nextEl": ".products-carousel__next-1",
                    "prevEl": ".products-carousel__prev-1"
                },
                "breakpoints": {
                    "320": {
                    "slidesPerView": 2,
                    "slidesPerGroup": 2,
                    "spaceBetween": 15
                    },
                    "768": {
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "spaceBetween": 30
                    },
                    "992": {
                    "slidesPerView": 6,
                    "slidesPerGroup": 1,
                    "spaceBetween": 45,
                    "pagination": false
                    },
                    "1200": {
                    "slidesPerView": 8,
                    "slidesPerGroup": 1,
                    "spaceBetween": 60,
                    "pagination": false
                    }
                }
                }'>
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <div class="swiper-slide">
                                    <img loading="lazy" class="w-100 h-auto mb-3"
                                        src="{{ asset('uploads/category_images') }}/{{ $category->image }}" width="124"
                                        height="124" alt="" />
                                    <div class="text-center">
                                        <a href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">{{ $category->name }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->
                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                            data-date="18-3-2024" data-time="06:50">
                            <div class="day countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Days</span>
                            </div>
                            <div class="hour countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Hours</span>
                            </div>

                            <div class="min countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Mins</span>
                            </div>

                            <div class="sec countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Sec</span>
                            </div>
                        </div>

                        <a href="{{ route('shop.index') }}"
                            class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider"
                                data-settings='{
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "effect": "none",
                    "loop": false,
                    "breakpoints": {
                        "320": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 2,
                        "spaceBetween": 14
                        },
                        "768": {
                        "slidesPerView": 2,
                        "slidesPerGroup": 3,
                        "spaceBetween": 24
                        },
                        "992": {
                        "slidesPerView": 3,
                        "slidesPerGroup": 1,
                        "spaceBetween": 30,
                        "pagination": false
                        },
                        "1200": {
                        "slidesPerView": 4,
                        "slidesPerGroup": 1,
                        "spaceBetween": 30,
                        "pagination": false
                        }
                    }
                    }'>
                                <div class="swiper-wrapper">
                                    @foreach ($on_sale_products as $product)
                                        <div class="swiper-slide product-card product-card_style3">
                                            <div class="pc__img-wrapper">
                                                <a
                                                    href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                                    <img loading="lazy"
                                                        src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                                        width="258" height="313" alt="{{ $product->name }}"
                                                        class="pc__img">
                                                </a>
                                            </div>
                                            <div class="pc__info position-relative">
                                                <h6 class="pc__title"><a
                                                        href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                </h6>
                                                <div class="product-card__price d-flex">
                                                    <span class="money price text-secondary">
                                                        @if ($product->sales_price)
                                                            <s>Rs. {{ $product->regular_price }}</s> Rs.
                                                            {{ $product->sales_price }}
                                                        @else
                                                            Rs. {{ $product->regular_price }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div><!-- /.swiper-wrapper -->
                            </div><!-- /.swiper-container js-swiper-slider -->
                        </div><!-- /.position-relative -->
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="products-grid container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                <div class="row">
                    @foreach ($featured_products as $product)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                        <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            width="330" height="400" alt="{{ $product->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex align-items-center">
                                        <span class="money price text-secondary">
                                            @if ($product->sales_price)
                                                <s>Rs. {{ $product->regular_price }}</s> Rs. {{ $product->sales_price }}
                                            @else
                                                Rs. {{ $product->regular_price }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!-- /.row -->
            </section>
        </div>
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </main>
@endsection
