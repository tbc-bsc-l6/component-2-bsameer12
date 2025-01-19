@extends('layouts.app')
@section('website-content')
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Address</h2>
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
                            <a href="{{ route('user.address-details') }}" class="btn btn-sm btn-danger">Back</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-5">
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

                                <div class="card-header">
                                    <h5>Add New Address</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.address.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="id" name="id" value="{{ $address->id }}">
                                        <div class="row mt-5">
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="name" required=""
                                                        value="{{ $address->name) }}">
                                                    <label for="name">Full Name *</label>
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="phone" required=""
                                                        value="{{ $address->phone) }}">
                                                    <label for="phone">Phone Number *</label>
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="zip" required=""
                                                        value="{{ $address->zip) }}">
                                                    <label for="zip">Pincode *</label>
                                                    @error('zip')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3 mb-3">
                                                    <input type="text" class="form-control" name="province"
                                                        required="" value="{{ $address->province) }}">
                                                    <label for="province">Province *</label>
                                                    @error('province')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="city" required=""
                                                        value="{{ $address->city) }}">
                                                    <label for="city">Town / City *</label>
                                                    @error('city')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="address" required=""
                                                        value="{{ $address->address) }}">
                                                    <label for="address">House no, Building Name *</label>
                                                    @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="locality"
                                                        required="" value="{{ $address->locality) }}">
                                                    <label for="locality">Road Name, Area, Colony *</label>
                                                    @error('locality')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="landmark"
                                                        required="" value="{{ $address->landmark) }}">
                                                    <label for="landmark">Landmark *</label>
                                                    @error('landmark')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="district"
                                                        required="" value="{{ $address->district) }}">
                                                    <label for="district">District *</label>
                                                    @error('district')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="isdefault" name="isdefault"
                                                    @if ($address->isdefault == 1) checked @endif>
                                                <label class="form-check-label" for="isdefault">
                                                    Make as Default address
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        </div>
    </section>
    </main>
@endsection
