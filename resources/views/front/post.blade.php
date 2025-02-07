@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $post->heading }}</h2>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6212352ed76fda0a"></script>
    {{-- @dd($post) --}}
    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">


                <div class="col-lg-8 col-md-12">
                    <div class="featured-photo">
                        <img src="{{ asset('storage/' . $post->photo) }}" alt="">
                    </div>
                    <div class="sub">
                        <div class="item">
                            <b><i class="fa fa-clock-o"></i></b>
                            {{ date('d M, Y', strtotime($post->updated_at)) }}
                        </div>
                        <div class="item">
                            <b><i class="fa fa-eye"></i></b>
                            {{ $post->total_view }}
                        </div>
                    </div>
                    <div class="main-text">
                        {!! $post->content !!}
                    </div>

                </div>



            </div>
        </div>
    </div>
@endsection
