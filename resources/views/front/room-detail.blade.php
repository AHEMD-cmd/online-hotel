@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $room->name }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content room-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12 left">

                    <div class="room-detail-carousel owl-carousel">
                        <div class="item" style="background-image:url({{ asset('storage/' . $room->featured_photo) }});">
                            <div class="bg"></div>
                        </div>

                        @foreach ($room->photos as $item)
                            <div class="item" style="background-image:url({{ asset('storage/' . $item->photo) }});">
                                <div class="bg"></div>
                            </div>
                        @endforeach

                    </div>

                    <div class="description">
                        {!! $room->description !!}
                    </div>

                    <div class="amenity">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Amenities</h2>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($room->amenities as $amenity)
                                <div class="col-lg-6 col-md-12">
                                    <div class="item"><i class="fa fa-check-circle"></i> {{ $amenity->name }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="feature">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Features</h2>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Room Size</th>
                                    <td>{{ $room->size }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Beds</th>
                                    <td>{{ $room->total_beds }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Bathrooms</th>
                                    <td>{{ $room->total_bathrooms }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Balconies</th>
                                    <td>{{ $room->total_balconies }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($room->video_id != '')
                        <div class="video">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $room->video_id }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    @endif


                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 right">

                    <div class="sidebar-container" id="sticky_sidebar">

                        <div class="widget">
                            <h2>Room Price per Night</h2>
                            <div class="price">
                                ${{ $room->price }}
                            </div>
                        </div>
                        <div class="widget">
                            <h2>Reserve This Room</h2>
                            <form action="{{ route('cart.store') }}" method="post" id="cart-form">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">

                                <div class="form-group mb_20">
                                    <label for="">Check in & Check out</label>
                                    <input type="text" name="checkin_checkout" class="form-control daterange1"
                                        placeholder="Checkin & Checkout">
                                        <span class="text-danger error-checkin_checkout"></span>

                                </div>
                                <div class="form-group mb_20">
                                    <label for="">Adult</label>
                                    <input type="number" name="adults" class="form-control" min="1" max="30"
                                        placeholder="Adults">
                                        <span class="text-danger error-adults"></span>

                                </div>
                                <div class="form-group mb_20">
                                    <label for="">Children</label>
                                    <input type="number" name="children" class="form-control" min="0" max="30"
                                        placeholder="Children">
                                        <span class="text-danger error-children"></span>
                                </div>
                                <button type="submit" class="book-now">Add to Cart</button>
                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                iziToast.error({
                    title: '',
                    position: 'topRight',
                    message: '{{ $error }}',
                });
            </script>
        @endforeach
    @endif

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log('ready');
            $("#cart-form").submit(function(event) {
                event.preventDefault(); // Prevent normal form submission

                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $(".text-danger").text(""); // Clear previous error messages
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end', // Show at top-right corner
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000 // Auto close after 3 seconds
                            });

                            $("#cart-form")[0].reset(); // Reset form after success
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(".error-" + key).text(value[
                                0]); // Display validation error
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: "An unexpected error occurred!",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            console.error(xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
@endpush

