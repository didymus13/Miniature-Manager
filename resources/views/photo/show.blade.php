@extends('layouts.app')

@section('head')
    <title>{{ $photo->title or 'Photo for ' . $photo->imageable->label }}</title>
    <meta name="og:title" content="{{ $photo->title or 'Photo for ' . $photo->imageable->label }}"/>
    <meta name="og:description" content="{{ $photo->caption }}" />
    <meta name="og:image" content="{{ url( $photo->full_url) }}"/>
    <link rel="canonical" href="{{ route('photos.show', $photo->id) }}" />

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

    <div id="photo">
        <img src="{{ $photo->full_url }}" alt="related photo" class="img-responsive"/>
    </div>

    @include('share_buttons', [
        'exclude' => false,
        'shareSubject' => $photo->full_url,
        'shareText' => $photo->caption,
        'shareUrl' => route('photos.show', $photo->id)
    ])

    <p data-type="textarea" data-pk="{{ $photo->id }}" data-name="caption" data-title="Caption" data-url="{{ route('photos.update', $photo->id) }}"
       class="editable">
        {{ $photo->caption }}
    </p>

    @if(count($photo->siblings) > 0)
        <h2>Other photos</h2>
        <div class="row">
            @foreach($photo->siblings as $related)
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ route('photos.show', $related->id) }}">
                        <img src="{{ url($related->full_thumb_url) }}" alt="related photo" class="img-responsive"/>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section('endBody')
    @can('edit', $photo)
        <?php $token = csrf_token() ?>
        @include('js/editInPlace', ['token' => $token])
    @endCan
@endsection

