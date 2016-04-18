@extends('layouts.app')

@section('head')
    <title>Hobby Showcase</title>
    <link rel="canonical" href="{{ url('/', true) }}"/>

@section('content')
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
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Last Updated Collection
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

        {{-- Last Updated --}}
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Last Updated Collection
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
        <div class="col-xs-12 col-sm-4">Ad goes here</div>
    </div>
@endsection
