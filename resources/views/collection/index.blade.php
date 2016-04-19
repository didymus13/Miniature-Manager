@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('collections') !!}

    <div class="page-heading">
        <h1>Collections</h1>
        @if(Auth::check())
            <a href="{{ route('collections.create') }}" class="btn btn-primary">Create</a>
        @endif
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Tags</th>
            <th>Last Updated</th>
            <th>Progress</th>
        </tr>
        </thead>

        <tbody>
        @foreach($collections as $collection)
            <tr>
                <td><a href="{{ route('collections.show', $collection->slug) }}">{{ $collection->label }}</a></td>
                <td>
                    <ul class="list-inline">
                        @foreach($collection->tags as $tag)
                            <li>
                                <a href="{{ route('collections.index', ['tags' => $tag->slug]) }}" class="btn btn-xs btn-default">
                                    {{ $tag->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $collection->updated_at->diffForHumans() }}</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $collection->progress }}%">
                            {{ $collection->progress }}%
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection