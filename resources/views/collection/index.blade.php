@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h1>Collections</h1>
        @if(Auth::check())
            <a href="{{ route('collections.create') }}" class="btn btn-primary">Create</a>
        @endif
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Last Updated</th>
            <th>Progress</th>
        </tr>
        </thead>

        <tbody>
        @foreach($collections as $collection)
            <tr>
                <td><a href="{{ route('collections.show', $collection->slug) }}">{{ $collection->label }}</a></td>
                <td>{{ $collection->updated_at->diffForHumans() }}</td>
                <td>{{ $collection->progress or 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection