@extends('front.layout.app')

@section('main_content')
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Payment</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 checkout-left mb_30">


                    <h4>Make Payment</h4>
                    <select name="payment_method" class="form-control select2" id="paymentMethodChange" autocomplete="off">
                        <option value="">Select Payment Method</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Stripe">Stripe</option>
                    </select>

                    <form action="{{ route('payment.pay') }}" method="post" id="paymentForm">
                        @csrf
                        <input type="hidden" name="payment_method" id="paymentMethod">
                        <div class="paypal mt_20">
                            <h4>Pay with PayPal</h4>
                            <button type="submit" class="btn btn-primary">
                                Pay
                            </button>
                        </div>


                        <div class="stripe mt_20">
                            <h4>Pay with Stripe</h4>
                            <button type="submit" class="btn btn-primary">
                                Pay
                            </button>
                        </div>

                    </form>


                </div>

                <div class="col-lg-4 col-md-4 checkout-right">
                    <div class="inner">
                        <h4 class="mb_10">Billing Details</h4>
                        <div>
                            Name: {{ session()->get('billing_name') }}
                        </div>
                        <div>
                            Email: {{ session()->get('billing_email') }}
                        </div>
                        <div>
                            Phone: {{ session()->get('billing_phone') }}
                        </div>
                        <div>
                            Country: {{ session()->get('billing_country') }}
                        </div>
                        <div>
                            Address: {{ session()->get('billing_address') }}
                        </div>
                        <div>
                            State: {{ session()->get('billing_state') }}
                        </div>
                        <div>
                            City: {{ session()->get('billing_city') }}
                        </div>
                        <div>
                            Zip: {{ session()->get('billing_zip') }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 checkout-right">
                    <div class="inner">
                        <h4 class="mb_10">Cart Details</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>

                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('storage/' . $item->room->featured_photo) }}"></td>
                                            <td>
                                                <a href="{{ route('rooms.show', $item->room->id) }}"
                                                    class="room-name">{{ $item->room->name }}</a>
                                            </td>
                                            <td>${{ $item->subtotal }}</td>
                                            <td>{{ $item->checkin }}</td>
                                            <td>{{ $item->checkout }}</td>
                                            <td>
                                                Adult: {{ $item->adults }}<br>
                                                Children: {{ $item->children }}
                                            </td>
                                            <td>
                                                ${{ $item->subtotal }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">Total:</td>

                                        <td colspan="4">${{ $cartTotal }}</td>
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


