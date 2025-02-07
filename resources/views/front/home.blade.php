@extends('front.layout.app')

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('main_content')
    <div class="slider">
        <div class="slide-carousel owl-carousel">
            @foreach ($sliders as $slider)
                <div class="item" style="background-image:url({{ asset('storage/' . $slider->photo) }});">
                    <div class="bg"></div>
                    <div class="text">
                        <h2>{{ $slider->heading }}</h2>
                        <p id="booking-form">
                            {!! $slider->text !!}
                        </p>
                        @if ($slider->button_text != '')
                            <div class="button">
                                <a href="{{ $slider->button_url }}">{{ $slider->button_text }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="search-section">
        <div class="container">
            <form id="cart-form" action="{{ route('cart.store') }}" method="post">
                @csrf
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <select name="room_id" class="form-select">
                                    <option value="">Select Room</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-room_id"></span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <input type="text" name="checkin_checkout" class="form-control daterange1"
                                    placeholder="Checkin & Checkout">
                                <span class="text-danger error-checkin_checkout"></span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="number" name="adults" class="form-control" min="1" max="30"
                                    placeholder="Adults">
                                <span class="text-danger error-adults"></span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="number" name="children" class="form-control" min="0" max="30"
                                    placeholder="Children">
                                <span class="text-danger error-children"></span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="success-message" class="alert alert-success mt-3" style="display:none;"></div>
        </div>
    </div>



    <div class="home-feature">
        <div class="container">
            <div class="row">

                @foreach ($features as $feature)
                    <div class="col-md-3">
                        <div class="inner">
                            <div class="icon"><i class="{{ $feature->icon }}"></i></div>
                            <div class="text">
                                <h2>{{ $feature->heading }}</h2>
                                <p>
                                    {!! $feature->text !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>




    <div class="home-rooms">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">Rooms and Suites</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($rooms as $room)
                    <div class="col-md-3">
                        <div class="inner">
                            <div class="photo">
                                <img src="{{ asset('storage/' . $room->featured_photo) }}" alt="">
                            </div>
                            <div class="text">
                                <h2><a href="{{ route('rooms.show', $room->id) }}">{{ $room->name }}</a></h2>
                                <div class="price">
                                    ${{ $room->price }}/night
                                </div>
                                <div class="button">
                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary">See Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="big-button">
                        <a href="{{ route('rooms') }}" class="btn btn-primary">See All Rooms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="testimonial" style="background-image: url(uploads/slide2.jpg)">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">Our Happy Clients</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="photo">
                                    <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="">
                                </div>
                                <div class="text">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->designation }}</p>
                                </div>
                                <div class="description">
                                    <p>
                                        {!! $testimonial->comment !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="blog-item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">Latest Posts</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="inner">
                            <div class="photo">
                                <img src="{{ asset('storage/' . $post->photo) }}" alt="">
                            </div>
                            <div class="text">
                                <h2><a href="{{ route('blogs.show', $post->id) }}">{{ $post->heading }}</a></h2>
                                <div class="short-des">
                                    <p>
                                        {!! $post->short_content !!}
                                    </p>
                                </div>
                                <div class="button">
                                    <a href="{{ route('blogs.show', $post->id) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>



    
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
