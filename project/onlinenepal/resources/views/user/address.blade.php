@extends('layouts.app')
@section('website-content')
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Addresses</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account_nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address">
                    <div class="row">
                        <div class="col-6">
                            <p class="notice">The following addresses will be used on the checkout page by default.</p>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('user.address-create') }}" class="btn btn-sm btn-info">Add New</a>
                        </div>
                    </div>
                    <div class="my-account__address-list row">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <h5>Shipping Address</h5>

                        <div class="my-account__address-item col-md-6">
                            <div class="my-account__address-item__title">
                                <h5>{{ Auth::user()->name }} <i class="fa fa-check-circle text-success"></i></h5>
                                <a href="{{route('user.address-modify')}}">Edit</a>
                            </div>
                            <div class="my-account__address-item__detail">
                                @if ($address)
                                    <p>{{ $address->address ?? 'N/A' }}</p>
                                    <p>{{ $address->locality ?? 'N/A' }}</p>
                                    <p>{{ $address->city ?? 'N/A' }}, {{ $address->district ?? 'N/A' }},
                                        {{ $address->province ?? 'N/A' }}, {{ $address->country ?? 'N/A' }}</p>
                                    <p>{{ $address->landmark ?? 'N/A' }}</p>
                                    <p>{{ $address->zip ?? 'N/A' }}</p>
                                    <br>
                                    <p>Mobile : +977 {{ $address->phone ?? 'N/A' }}</p>
                                @else
                                    <p>No address available.</p>
                                @endif

                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
@endsection
