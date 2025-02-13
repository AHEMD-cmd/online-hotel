<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <title>Hotel Website</title>

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">

    @include('front.layout.styles')

    @include('front.layout.scripts')


    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500&display=swap" rel="stylesheet">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->analytic_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $settings->analytic_id }}');
    </script>






    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('6c1d1953cdc25553023b', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('cart');
        channel.bind('CartUpdated', function(data) {
            console.log(data.cartCount);
            $('#cart-count').text(data.cartCount);
        });
    </script>



    @yield('css')
    @vite('resources/js/app.js')

</head>

<body>

    <div class="top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 left-side">
                    <ul>

                        @if ($settings->top_bar_phone != '')
                            <li class="phone-text">{{ $settings->top_bar_phone }}</li>
                        @endif

                        @if ($settings->top_bar_email != '')
                            <li class="email-text">{{ $settings->top_bar_email }}</li>
                        @endif

                    </ul>
                </div>
                <div class="col-md-6 right-side">
                    <ul class="right">

                        <li class="menu"><a href="{{ route('cart') }}">Cart

                                <sup
                                    id="cart-count">{{ \App\Models\Cart::where('user_id', Auth::id())->orWhere('id', $cartId)->count() }}</sup>

                            </a></li>


                        <li class="menu"><a href="{{ route('checkout') }}">Checkout</a></li>



                        @if (!Auth::check())
                            <li class="menu"><a href="{{ route('register') }}">Register</a>
                            </li>

                            <li class="menu"><a href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="menu"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="navbar-area" id="stickymenu">

        <!-- Menu For Mobile Device -->
        <div class="mobile-nav">
            <a href="index.html" class="logo">
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="">
            </a>
        </div>

        <!-- Menu For Desktop Device -->
        <div class="main-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Home</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('about') }}" class="nav-link">About us</a>
                            </li>

                            <li class="nav-item">
                                <a href="javascript:void;" class="nav-link dropdown-toggle">Room & Suite</a>
                                <ul class="dropdown-menu">
                                    @foreach ($rooms as $room)
                                        <li class="nav-item">
                                            <a href="{{ route('rooms.show', $room->id) }}"
                                                class="nav-link">{{ $room->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>



                            <li class="nav-item">
                                <a href="javascript:void;" class="nav-link dropdown-toggle">Gallery</a>
                                <ul class="dropdown-menu">


                                    <li class="nav-item">
                                        <a href="{{ route('photo.gallery') }}" class="nav-link">Photo Gallery</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('video.gallery') }}" class="nav-link">Video Gallery</a>
                                    </li>


                                </ul>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('blogs.index') }}" class="nav-link">Blog</a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                            </li>


                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>


    @yield('main_content')


    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">Site Links</h2>
                        <ul class="useful-links">

                            <li><a href="{{ route('photo.gallery') }}">Photo Gallery</a>
                            </li>



                            <li><a href="{{ route('video.gallery') }}">Video Gallery</a>
                            </li>


                            <li><a href="{{ route('blogs.index') }}">Blog</a></li>

                            <li><a href="{{ route('contact') }}">Contact</a></li>

                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">Useful Links</h2>
                        <ul class="useful-links">
                            <li><a href="{{ route('home') }}">Home</a></li>

                            <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>


                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>


                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">Contact</h2>
                        <div class="list-item">
                            <div class="left">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="right">
                                {!! nl2br($settings->footer_address) !!}
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="fa fa-volume-control-phone"></i>
                            </div>
                            <div class="right">
                                {{ $settings->footer_phone }}
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="right">
                                {{ $settings->footer_email }}
                            </div>
                        </div>
                        <ul class="social">

                            @if ($settings->facebook != '')
                                <li><a href="{{ $settings->facebook }}"><i class="fa fa-facebook-f"></i></a></li>
                            @endif

                            @if ($settings->twitter != '')
                                <li><a href="{{ $settings->twitter }}"><i class="fa fa-twitter"></i></a></li>
                            @endif

                            @if ($settings->linkedin != '')
                                <li><a href="{{ $settings->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
                            @endif

                            @if ($settings->pinterest != '')
                                <li><a href="{{ $settings->pinterest }}"><i class="fa fa-pinterest-p"></i></a></li>
                            @endif

                        </ul>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="item">
                        <h2 class="heading">Newsletter</h2>
                        <p>
                            In order to get the latest news and other great items, please subscribe us here:
                        </p>
                        <form action="{{ route('subscriber.send.email') }}" method="post"
                            class="form_subscribe_ajax">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="email" class="form-control">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Subscribe Now">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="copyright">
        {{ $settings->copyright }}
    </div>

    <div class="scroll-top">
        <i class="fa fa-angle-up"></i>
    </div>

    @include('front.layout.scripts_footer')

    @if (session()->get('error'))
        <script>
            iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{ session()->get('error') }}',
            }); 
        </script>
            @endif

            @if (session()->get('success'))
        <script >
                    iziToast.success({
                        title: '',
                        position: 'topRight',
                        message: '{{ session()->get('success') }}',
                    });
        </script>
    @endif

    <script>
        (function($) {
            $(".form_subscribe_ajax").on('submit', function(e) {
                e.preventDefault();
                $('#loader').show();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        $('#loader').hide();
                        if (data.code == 0) {
                            $.each(data.error_message, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.code == 1) {
                            $(form)[0].reset();
                            iziToast.success({
                                title: '',
                                position: 'topRight',
                                message: data.success_message,
                            });
                        }

                    }
                });
            });
        })(jQuery);
    </script>
    <div id="loader"></div>

    @stack('scripts')

</body>

</html>
