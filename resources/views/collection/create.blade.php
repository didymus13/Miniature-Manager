@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h1>Create a new collection</h1>
    </div>

    {!! Form::open(['route' => 'collections.store', 'method' => 'POST']) !!}
    @include('collection.form')
    {!! Form::close() !!}
@endsection