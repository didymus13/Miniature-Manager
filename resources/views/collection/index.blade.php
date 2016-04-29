@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('collections') !!}

    <div class="page-heading">
        <h1>Collections</h1>
        @if(Auth::check())
            <a href="{{ route('collections.create') }}" class="btn btn-primary">Create</a>
        @endif
    </div>

        @foreach($collections as $collection)
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-2">
                            @if ($collection->featuredImage)
                                <a href="{{ route('collections.show', $collection->slug) }}">
                                    <img src="{{$collection->featuredImage->fullThumbnailUrl}}" class="img-responsive"
                                         alt="{{ $collection->featuredImage->caption }}" />
                                </a>
                            @endif
                        </div>

                        <div class="col-xs-6 col-sm-10">
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $collection->progress }}%">
                                    {{ $collection->progress }}%
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-4">
                            <a href="{{ route('collections.show', $collection->slug) }}">{{ $collection->label }}</a>
                        </div>

                        <div class="col-xs-6 col-sm-4">
                            <ul class="list-inline">
                                <li>Tags:</li>
                                @foreach($collection->tags as $tag)
                                    <li>
                                        <a href="{{ route('collections.index', ['tags' => $tag->slug]) }}" class="btn btn-xs btn-default">
                                            {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-6 col-sm-2">
                            <span class="fa fa-fw fa-clock-o"></span>
                            {{ $collection->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection