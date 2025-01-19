@extends('layouts.app')
@section('website-content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>
            <div class="shopping-cart">
                <div class="cart-table__wrapper">
                    @if ($items->count() > 0)
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th></th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/' . $item->options->image) }}"
                                                    width="120" height="120" alt="{{ $item->name }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $item->name }}</h4>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__product-price">Rs. {{ $item->price }}</span>
                                        </td>
                                        <td>
                                            {{ $item->qty }}
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <form method="POST"
                                                        action="{{ route('wishlist.move.to.cart', ['rowId' => $item->rowId]) }}">
                                                        @csrf
                                                        <button class="btn btn-sm btn-warning" type="submit">Add To
                                                            Cart</button>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <form method="POST"
                                                        action="{{ route('wishlist.delete', ['rowId' => $item->rowId]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0)" class="remove-cart" style="color:red;">
                                                            <svg width="10" height="10" viewBox="0 0 10 10"
                                                                fill="red" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                                <path
                                                                    d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                            </svg>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form method="POST" action="{{ route('wishlist.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light" type="submit">Clear Wishlist</button>
                        </form>
                </div>
            @else
                <div class="row">
                    <div class="col-md 12 text-center pt-5 bp-5">
                        <p>Your Wishlist is Empty!!!!</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-info">Add To Wishlist</a>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </main>
@endsection
@push('website-script')
    <script>
        $(function() {
            $('.remove-cart').on('click', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
