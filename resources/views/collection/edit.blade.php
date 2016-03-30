@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h1>Editing: {{ $collection->label }}</h1>
    </div>

    {!! Form::model($collection, ['route' => ['collections.update', $collection->slug], 'method' => 'PATCH']) !!}
    @include('collection.form')
    {!! Form::close() !!}
@endsection