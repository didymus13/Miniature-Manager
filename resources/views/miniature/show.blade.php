@extends('layouts.app')

@section('head')
    <title>{{ $miniature->label }}</title>
    <meta name="description" content="{{ $miniature->label }}"/>
    <meta property="og:title" content="{{ $miniature->label }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('miniatures.show', $miniature->slug, true) }}" />

    @if($miniature->featuredImage)
        <meta property="og:image" content="{{ url('/uploads/' . $miniature->featuredImage->url) }}" />
    @endif

    <link rel="canonical" href="{{ route('miniatures.show', $miniature->slug, true) }}"/>
@endsection

@section('content')
    <div class="page-header">
        <h1>{{ $miniature->label }}</h1>
    </div>

    {!! Breadcrumbs::render('miniature', $miniature) !!}

    <article>
        <div class="page-heading">
            <h1>
                {{ $miniature->label }}
            </h1>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $miniature->progress }}%">{{ $miniature->progress }}%</div>
            </div>
        </div>

        <ul class="list-inline">
            <li><span class="fa fa-user"></span></li>
            <li>{{ $miniature->collection->user->name }}</li>
            <li><span class="fa fa-calendar"></span> {{ $miniature->updated_at->diffForHumans() }}</li>
            <li>

            </li>
        </ul>

        <div class="row">
            <!-- photo Gallery -->
            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-9">
                <div id="photo-gallery" class="row">
                    @foreach($miniature->photos as $photo)
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ route('photos.show', $photo->id) }}">
                                <img src="{{ url('/uploads/' . $photo->thumb_url) }}" alt="{{ $photo->caption }}" class="img-responsive"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 ads">
                @include('ads')
            </div>
        </div>
    </article>
@endsection