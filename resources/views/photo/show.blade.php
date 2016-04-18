@extends('layouts.app')

@section('head')
    <title>{{ $photo->caption or 'Photo for ' . $photo->imageable->label }}</title>
    <meta name="og:title" content="{{ $photo->caption or 'Photo for ' . $photo->imageable->label }}"/>
    <meta name="og:image" content="{{ url('/uploads/' . $photo->url) }}"/>
    <link rel="canonical" href="{{ route('collections.show', $photo->imageable->collection->slug) }}" />
@endsection

@section('content')
    {!! Breadcrumbs::render('photo',$photo) !!}

    <div class="page-header">
        <h1>Photo for {{ $photo->imageable->label }}</h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <img src="{{ url('/uploads/' . $photo->url) }}" alt="related photo" class="img-responsive"/>

            <!-- Share Buttons -->
            <div class="share-block">
                <a href="https://www.pinterest.com/pin/create/button/?media={{ url('/uploads/' . $photo->url) }}&url={{ route('photos.show', $photo->id) }}&description={{ urlencode($photo->label) }}"
                   data-pin-do="buttonPin" data-pin-color="red">
                </a>
                <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
            </div>

        </div>
    </div>

    @if(count($photo->siblings) > 0)
        <h2>Other photos</h2>
        <div class="row">
            @foreach($photo->siblings as $related)
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('photos.show', $related->id) }}">
                        <img src="{{ url('/uploads/' . $related->url) }}" alt="related photo" class="img-responsive"/>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section('endBody')
    {{--share buttons--}}
    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    {{--end share button code--}}
@endsection