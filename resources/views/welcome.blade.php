@extends('layouts.app')

@section('head')
    <title>Hobby Showcase</title>
    <link rel="canonical" href="{{ url('/', true) }}"/>

@section('content')
    {!! Breadcrumbs::render('home') !!}
    <div class="page-header">
        <h1>Hobby showcase</h1>
    </div>
    <div class="row">
        {{-- Photo Gallery --}}
        <div class="col-xs-12 col-sm-8 col-md-9">
            <div class="row">
                @foreach($homepage->newPhotos as $photo)
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                        <a href="{{ route('photos.show', $photo->id) }}">
                            <img src="{{ url('/uploads/' . $photo->url) }}" alt="{{ $photo->caption }}"
                                 class="img-responsive"/>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tags List --}}
        <div class="col-xs-12 col-sm-4 col-md-3">
            <h3>Most Popular Tags:</h3>
            <ul class="nav nav-pills nav-stacked">
                @foreach($homepage->topTags as $tag)
                    <li>
                        <a href="{{ route('collections.index', ['tags' => $tag->tag_slug]) }}">
                            {{ $tag->tag_name }} <span class="badge pull-right">{{ $tag->counts }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Panels --}}
    <div class="row">
        {{-- most viewed --}}
        @if($homepage->mostViewedCollection)
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Most Viewed Collection
                </div>
                <div class="panel-body">
                    <a href="{{ route('collections.show', $homepage->mostViewedCollection->slug) }}">
                        @if($homepage->mostViewedCollection->featuredImage)
                            <img src="{{ url('/uploads/' . $homepage->mostViewedCollection->featuredImage->url) }}"
                                 class="img-responsive" alt="{{ $homepage->mostViewedCollection->label }}">
                        @endif
                        {{ $homepage->mostViewedCollection->label }}
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($homepage->lastUpdatedCollection)
        {{-- Last Updated --}}
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Last Updated Collection
                </div>
                <div class="panel-body">
                    <a href="{{ route('collections.show', $homepage->lastUpdatedCollection->slug) }}">
                        @if($homepage->lastUpdatedCollection->featuredImage)
                            <img src="{{ url('/uploads/' . $homepage->lastUpdatedCollection->featuredImage->url) }}"
                                 class="img-responsive" alt="{{ $homepage->lastUpdatedCollection->label }}">
                        @endif
                        {{ $homepage->lastUpdatedCollection->label }}
                    </a>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xs-12 col-sm-4">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- ResponsiveBlock -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-7113319988018316"
                 data-ad-slot="4780040988"
                 data-ad-format="auto"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
@endsection
