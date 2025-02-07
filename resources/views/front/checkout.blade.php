@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-6 checkout-left">

                    <form action="{{ route('payment') }}" method="post" class="frm_checkout">
                        @csrf
                        <div class="billing-info">
                            <h4 class="mb_30">Billing Information</h4>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="">Name: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_name"
                                        value="{{ old('billing_name', auth()->user()->name) }}">
                                    @error('billing_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Email Address: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_email"
                                        value="{{ old('billing_email', auth()->user()->email) }}">
                                    @error('billing_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Phone Number: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_phone"
                                        value="{{ old('billing_phone', auth()->user()->phone) }}">
                                    @error('billing_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Country: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_country"
                                        value="{{ old('billing_country', auth()->user()->country) }}">
                                    @error('billing_country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Address: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_address"
                                        value="{{ old('billing_address', auth()->user()->address) }}">
                                    @error('billing_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">State: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_state"
                                        value="{{ old('billing_state', auth()->user()->state) }}">
                                    @error('billing_state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">City: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_city"
                                        value="{{ old('billing_city', auth()->user()->city) }}">
                                    @error('billing_city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Zip Code: *</label>
                                    <input type="text" class="form-control mb_15" name="billing_zip"
                                        value="{{ old('billing_zip', auth()->user()->zip) }}">
                                    @error('billing_zip')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary bg-website mb_30">Continue to payment</button>
                    </form>
                </div>
                <div class="col-lg-4 col-md-6 checkout-right">
                    <div class="inner">
                        <h4 class="mb_10">Cart Details</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>


                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>
                                                {{ $item->room->name }}
                                                <br>
                                                ({{ $item->checkin }} - {{ $item->checkout }})
                                                <br>
                                                Adult: {{ $item->adults }}, Children: {{ $item->children }}
                                            </td>
                                            <td class="p_price">
                                                {{ $item->subtotal }}
                                            </td>
                                        </tr>
                                    @endforeach


                                    <tr>
                                        <td><b>Total:</b></td>
                                        <td class="p_price"><b>${{ $cartTotal }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
