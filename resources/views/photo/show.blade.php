@extends('layouts.app')

@section('head')
    <title>{{ $photo->caption or 'Photo for ' . $photo->imageable->label }}</title>
    <meta name="og:title" content="{{ $photo->caption or 'Photo for ' . $photo->imageable->label }}"/>
    <meta name="og:image" content="{{ url('/uploads/' . $photo->url) }}"/>
    <link rel="canonical" href="{{ route('collections.show', $photo->imageable->collection->slug) }}" />

    @can('edit', $photo)
        @include('css/editInPlace')
    @endCan
@endsection

@section('content')
    {!! Breadcrumbs::render('photo',$photo) !!}

    <div class="page-header">
        <h1 data-type="text" data-pk="{{ $photo->id }}" data-name="title"
            data-url="{{ route('photos.update', $photo->id) }}" data-title="Title" class="editable">
            {{ $photo->title or 'Photo for ' . $photo->imageable->label }}
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9" id="photo">
            <p>
                <img src="{{ url('/uploads/' . $photo->url) }}" alt="related photo" class="img-responsive"/>
            </p>
            <p data-type="textarea" data-pk="{{ $photo->id }}" data-name="caption" data-title="Caption" data-url="{{ route('photos.update', $photo->id) }}"
               class="editable">
                {{ $photo->caption }}
            </p>
            <!-- Share Buttons -->
            <div class="share-block">
                <a href="https://www.pinterest.com/pin/create/button/?media={{ url('/uploads/' . $photo->url) }}&url={{ route('photos.show', $photo->id) }}&description={{ urlencode($photo->label) }}"
                   data-pin-do="buttonPin" data-pin-color="red">
                </a>
                <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
            </div>
        </div>
        <div class="ads col-xs-12 col-sm-12 col-md-4 col-lg-3">
            @can('edit', $photo)
            @else
                @include('ads')
            @endcan
        </div>
    </div>

    @if(count($photo->siblings) > 0)
        <h2>Other photos</h2>
        <div class="row">
            @foreach($photo->siblings as $related)
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('photos.show', $related->id) }}">
                        <img src="{{ url($related->fullThumbnailUrl) }}" alt="related photo" class="img-responsive"/>
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

    @can('edit', $photo)
        <?php $token = csrf_token() ?>
        @include('js/editInPlace', ['token' => $token])
    @endCan
@endsection