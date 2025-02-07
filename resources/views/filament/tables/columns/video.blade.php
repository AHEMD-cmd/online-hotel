{{-- {{ dd($getState()) }} <!-- This will dump the value --> --}}

@if ($getState())
    <iframe width="200" height="150" src="https://www.youtube.com/embed/{{ $getState() }}" frameborder="0" allowfullscreen></iframe>
@else
    <span class="text-gray-500">No video</span>
@endif
