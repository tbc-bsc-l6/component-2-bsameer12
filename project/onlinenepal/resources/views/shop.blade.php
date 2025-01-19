@extends('layouts.app')
@section('website-content')
    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>
                <div class="pt-4 pt-lg-0"></div>
                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                                aria-controls="accordion-filter-1">
                                Product Categories
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach ($categories as $category)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="categories" value="{{ $category->id }}"
                                                    class="chk-category"
                                                    @if (in_array($category->id, $categories_filter)) checked="checked" @endif>
                                                {{ $category->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ $category->products->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                                aria-controls="accordion-filter-brand">
                                Brands
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                            aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <ul class="list list-inline mb-0 brand-list">
                                    @foreach ($brands as $brand)
                                        <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{ $brand->id}}"
                                                    class="chk-brand"
                                                    @if (in_array($brand->id, $brand_filter)) checked="checked" @endif>
                                                {{ $brand->name }}
                                            </span>
                                            <span class="text-right float-end">
                                                {{ $brand->products->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4">
                        <h5 class="accordion-header mb-2" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                                data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                                aria-controls="accordion-filter-price">
                                Price
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <!-- noUiSlider Container -->
                            <div id="price-range-slider" 
                                style="
                                    width: 90%; 
                                    height: 6px; 
                                    margin: 20px auto; 
                                    background-color: #ddd; 
                                    border-radius: 4px; 
                                    position: relative;">
                            </div>
                
                            <!-- Handles for noUiSlider -->
                            <div class="noUi-handle" 
                                style="
                                    width: 12px; 
                                    height: 12px; 
                                    position: absolute; 
                                    top: -3px; 
                                    left: 0; /* Adjust as per initial position */
                                    background-color: #007bff; 
                                    border: 2px solid #fff; 
                                    border-radius: 50%; 
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                            </div>
                
                            <div class="noUi-handle" 
                                style="
                                    width: 12px; 
                                    height: 12px; 
                                    position: absolute; 
                                    top: -3px; 
                                    right: 0; /* Adjust as per initial position */
                                    background-color: #007bff; 
                                    border: 2px solid #fff; 
                                    border-radius: 50%; 
                                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                            </div>
                
                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">Min Price: </span>
                                    <span class="price-range__min" id="min-price-display">Rs. 250</span>
                                </div>
                                <div>
                                    <span class="text-secondary">Max Price: </span>
                                    <span class="price-range__max" id="max-price-display">Rs. 450</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <div class="shop-list flex-grow-1">

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home.index') }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div>

                    <div
                        class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Page Size" id="pagesize" name="pagesize" style="margin-right: 20px;">
                            <option value='12' {{ $size == 12 ? 'selected' : ' ' }}>Page Size</option>
                            <option value='24' {{ $size == 24 ? 'selected' : ' ' }}>24</option>
                            <option value='48' {{ $size == 48 ? 'selected' : ' ' }}>48</option>
                            <option value='96' {{ $size == 96 ? 'selected' : ' ' }}>96</option>
                        </select>

                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                            aria-label="Sort Items" name="orderby" id="orderby" name="orderby">
                            <option value="-1" {{ $order == -1 ? 'selected' : '' }}>Default Sorting</option>
                            <option value="1" {{ $order == 1 ? 'selected' : '' }}>Alphabetically, A-Z</option>
                            <option value="2" {{ $order == 2 ? 'selected' : '' }}>Alphabetically, Z-A</option>
                            <option value="3" {{ $order == 3 ? 'selected' : '' }}>Price, low to high</option>
                            <option value="4" {{ $order == 4 ? 'selected' : '' }}>Price, high to low</option>
                            <option value="5" {{ $order == 5 ? 'selected' : '' }}>Date, old to new</option>
                            <option value="6" {{ $order == 6 ? 'selected' : '' }}>Date, new to old</option>
                        </select>

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">View</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                                data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                                data-cols="4">4</button>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                                data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10"
                                    viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card-wrapper">
                            <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper">
                                    <div class="swiper-container background-img js-swiper-slider"
                                        data-settings='{"resizeObserver": true}'>
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a
                                                    href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"><img
                                                        loading="lazy"
                                                        src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                                        width="330" height="400" alt="{{ $product->name }}"
                                                        class="pc__img"></a>
                                            </div>
                                            <div class="swiper-slide">
                                                @foreach (explode(',', $product->images) as $image)
                                                    <a
                                                        href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"><img
                                                            loading="lazy"
                                                            src="{{ asset('uploads/products') }}/{{ $image }}"
                                                            width="330" height="400" alt="{{ $product->name }}"
                                                            class="pc__img"></a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_prev_sm" />
                                            </svg></span>
                                        <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_next_sm" />
                                            </svg></span>
                                    </div>
                                    @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                                        <a href="{{ route('cart.index') }}"
                                            class=" pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn btn-warning mb-3">Go
                                            to Cart</a>
                                    @else
                                        <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <button type="submit"
                                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium "
                                                data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                            <input type="hidden" name="id" value="{{ $product->id }}" />
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                            <input type="hidden" name="image" value="{{ $product->image }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="price"
                                                value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                                        </form>
                                    @endif
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->category->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price">
                                            @if ($product->sales_price)
                                                <s>Rs. {{ $product->regular_price }}</s> Rs. {{ $product->sales_price }}
                                            @else
                                                Rs. {{ $product->regular_price }}
                                            @endif
                                        </span>
                                    </div>
                                    @if (Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                                        <form method="POST"
                                            action="{{ route('wishlist.delete', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                                                title="Remove To Wishlist" style="color : red; background-color:red;"
                                                type="submit">
                                                <svg width="16" height="16" viewBox="0 0 20 20"
                                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form name="addtowishlist-form" method="POST"
                                            action="{{ route('wishlist.add') }}">
                                            @csrf
                                            <button
                                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist" type="submit">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                            <input type="hidden" name="id" value="{{ $product->id }}" />
                                            <input type="hidden" name="name" value="{{ $product->name }}" />
                                            <input type="hidden" name="image" value="{{ $product->image }}" />
                                            <input type="hidden" name="quantity" value="1" />
                                            <input type="hidden" name="price"
                                                value="{{ $product->sales_price == '' ? $product->regular_price : $product->sales_price }}" />
                                        </form>
                                    @endif
                                </div>

                                <div
                                    class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-between">
                                    <div class="pc-labels__right ms-auto">
                                        <span class="pc-label pc-label_sale d-block text-white">-67%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>
    </main>

    <form id="fliterform" method="GET" action="{{ route('shop.index') }}">
        <input type="hidden" name="page" value="{{ $products->currentPage() }}">
    <input type="hidden" name="size" id="size" value="{{ $size }}">
    <input type="hidden" name="order" id="order" value="{{ $order }}">
    <input type="hidden" name="brands" id="hdnbrands" value="{{ implode(',', $brand_filter) }}">
    <input type="hidden" name="categories" id="hdncategories" value="{{ implode(',', $categories_filter) }}">
    <input type="hidden" name="min" id="hdnminimum_price" value="{{ $minimum_price }}">
    <input type="hidden" name="max" id="hdnmaximum_price" value="{{ $maximum_price }}">
    </form>
@endsection
@push('website-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script>
$(function(){
    $("#pagesize").on("change", function() {
        $("#size").val($(this).val()); // Correctly fetch the value of the selected option
        $("#fliterform").submit();
    });

    $("#orderby").on("change", function() {
        $("#order").val($(this).val()); // Correctly fetch the value of the selected option
        $("#fliterform").submit();
    });
    $("input[name='brands']").on("change",function(){
        var brands = "";
        $("input[name='brands']:checked").each(function(){
            if(brands == ""){
                brands += $(this).val();
            }
            else
            {
                brands += "," + $(this).val();
            }
        });
        $("#hdnbrands").val(brands); // Correctly fetch the value of the selected option
        $("#fliterform").submit();
    });
    $("input[name='categories']").on("change",function(){
        var categories = "";
        $("input[name='categories']:checked").each(function(){
            if(categories == ""){
                categories += $(this).val();
            }
            else
            {
                categories += "," + $(this).val();
            }
        });
        $("#hdncategories").val(categories); // Correctly fetch the value of the selected option
        $("#fliterform").submit();
    });
});
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('price-range-slider');

        // Dynamically get min and max price from PHP variables
        const minPrice = <?php echo $minimum_price; ?>;
        const maxPrice = <?php echo $maximum_price; ?>;

        // Initialize noUiSlider
        noUiSlider.create(slider, {
            start: [250, 450], // Initial min and max values
            connect: true,
            range: {
                'min': minPrice,
                'max': maxPrice
            },
            step: 100,
            tooltips: [false, false],
            format: {
                to: function (value) {
                    return Math.round(value);
                },
                from: function (value) {
                    return Number(value);
                }
            }
        });

        // Update displayed values dynamically
        slider.noUiSlider.on('update', function (values) {
            document.getElementById('min-price-display').innerText = 'Rs. ' + values[0];
            document.getElementById('max-price-display').innerText = 'Rs. ' + values[1];
        });

        // Submit form when values change
        slider.noUiSlider.on('change', function (values) {
            document.getElementById('hdnminimum_price').value = values[0];
            document.getElementById('hdnmaximum_price').value = values[1];
            setTimeout(() => { document.getElementById('fliterform').submit(); }, 2000);
        });
    });

</script>
@endpush 