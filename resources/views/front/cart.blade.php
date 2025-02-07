@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Cart</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row cart">
                <div class="col-md-12">


                    @if (count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-cart">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Serial</th>
                                        <th>Photo</th>
                                        <th>Room Info</th>
                                        <th>Price/Night</th>
                                        <th>Checkin</th>
                                        <th>Checkout</th>
                                        <th>Guests</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('cart.delete', $item->id) }}" class="cart-delete-link"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('storage/' . $item->room->featured_photo) }}"></td>
                                            <td>
                                                <a href="{{ route('rooms.show', $item->room->id) }}"
                                                    class="room-name">{{ $item->room->name }}</a>
                                            </td>
                                            <td>${{ $item->price }}</td>
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
                                        <td colspan="8" class="tar">Total:</td>
                                        <td>${{ $cartTotal }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="checkout mb_20">
                            <a href="{{ route('checkout') }}" class="btn btn-primary bg-website">Checkout</a>
                        </div>
                    @else
                        <div class="text-danger mb_30">
                            Cart is empty!
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            $('.cart-delete-link').on('click', function(event) {
                event.preventDefault(); // منع الانتقال المباشر للرابط

                let url = $(this).attr('href'); // الحصول على رابط الحذف

                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "نعم، احذف!",
                    cancelButtonText: "إلغاء"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // تنفيذ الحذف بعد التأكيد
                    }
                });
            });
        });
    </script>
@endpush
