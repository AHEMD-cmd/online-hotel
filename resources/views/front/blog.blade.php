@extends('front.layout.app')

@section('main_content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Posts</h2>
            </div>
        </div>
    </div>
</div>

<div class="blog-item">
    <div class="container">
        <div class="row">
            @foreach($posts as $post)
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <img src="{{ asset('storage/'.$post->photo) }}" alt="">
                    </div>
                    <div class="text">
                        <h2><a href="{{ route('blogs.show',$post->id) }}">{{ $post->heading }}</a></h2>
                        <div class="short-des">
                            <p>
                                {!! $post->short_content !!}
                            </p>
                        </div>
                        <div class="button">
                            <a href="{{ route('blogs.show',$post->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                {{ $posts->links() }}
            </div>
        </div>

    </div>
</div>
@endsection