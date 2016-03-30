@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h1>{{ $collection->label }}</h1>
    </div>

    <ul class="list-inline">
        @can('edit', $collection)
        <li><a href="{{ route('collections.edit', $collection->slug) }}" class="btn btn-primary">Edit</a></li>
        @endcan
        @can('delete', $collection)
        {!! Form::open(['route' => ['collections.destroy', $collection->slug], 'method' => 'DELETE']) !!}
        <li>{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}</li>
        {!! Form::close() !!}
        @endcan
    </ul>

    <p>{{ $collection->description }}</p>

    <table class="table">
        <caption>Miniatures</caption>
        <thead>
        <tr>
            <th>Name</th>
            <th>Last Updated</th>
            <th>Progress</th>
        </tr>
        </thead>

        <tbody>
        @foreach($collection->miniatures as $mini)
            <tr>
                <td>{{ $mini->label }}</td>
                <td>{{ $mini->updated_at->diffForHumans() }}</td>
                <td>{{ $mini->progress or 0 }}%</td>
            </tr>
        @endforeach
        </tbody>
        @can('edit', $collection)
        {!! Form::open(['route' => ['miniatures.store']]) !!}
        <tfoot>
        <tr>
            <td
        </tr>
        </tfoot>
        @endcan
    </table>
@endsection