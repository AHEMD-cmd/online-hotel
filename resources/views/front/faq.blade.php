@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>FAQ</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        @foreach ($faqs as $index => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index + 1 }}">
                                    <button class="accordion-button @if ($index != 0) collapsed @endif"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index + 1 }}"
                                        aria-expanded="@if ($index == 0) true @else false @endif"
                                        aria-controls="collapse{{ $index + 1 }}">
                                        {{ $item->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index + 1 }}"
                                    class="accordion-collapse collapse @if ($index == 0) show @endif"
                                    aria-labelledby="heading{{ $index + 1 }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $item->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
