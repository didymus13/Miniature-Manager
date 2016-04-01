@extends('layouts.app')

<?php $token = csrf_token() ?>

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
            <th>Progress</th>
            <th>Last Updated</th>
        </tr>
        </thead>

        <tbody>
        @foreach($collection->miniatures as $mini)
            <tr>
                <td>
                    <span data-type="text" data-pk="{{ $mini->slug }}" data-name="label"
                          data-url="{{ route('miniatures.update', $mini->slug) }}" data-title="Name" class="editable">
                        {{ $mini->label }}
                    </span>
                </td>
                <td>
                    <div class="progress" data-value="{{ $mini->progress }}">
                        <div class="progress-bar" style="width: {{$mini->progress}}%">
                            <span class="editable" data-type="number" data-pk="{{ $mini->slug }}" data-name="progress"
                                  data-url="{{ route('miniatures.update', $mini->slug) }}" data-title="Progress">
                                {{ $mini->progress }}
                            </span> %
                        </div>
                    </div>
                </td>
                <td>{{ $mini->updated_at->diffForHumans() }}</td>
                @can('delete', $mini)
                <td>
                    <span data-url="{{ route('miniatures.destroy', $mini->slug) }}"
                          class="btn btn-danger confirm destroy">
                        Delete
                    </span>
                </td>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>

    @can('edit', $collection)
    {!! Form::open(['route' => ['miniatures.store'], 'method' => 'POST', 'class' => 'form-inline']) !!}
    {!! Form::hidden('collection', $collection->slug) !!}
    <div class="form-group">
        {!!  Form::label('label', 'Name:') !!}
        {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'New Miniature']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('progress', 'Progress:') !!}
        {!! Form::number('progress', null, ['class' => 'form-control', 'placeholder' => '0', 'min' => 0, 'max' => 100]) !!}
    </div>
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    @endcan
@endsection

@section('endBody')
    @can('edit', $collection)
    <script>
        $(function () {
            $.fn.editable.defaults.ajaxOptions = {method: 'PATCH'};
            $(".editable").editable({
                params: function (params) {
                    var data = {};
                    data['id'] = params.pk;
                    data[params.name] = params.value;
                    data['_token'] = '{{ $token }}';
                    return data;
                },
                success: function (response, newValue) {
                    var parent = $(this).parent();
                    if (parent.hasClass('progress-bar')) {
                        parent.width(newValue + '%');
                    }
                }
            });

            $('tbody').delegate('.confirm.destroy', 'click', function (event) {
                if (!confirm('Are you sure?')) {
                    return;
                }
                var row = $(this).closest('tr');
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: {_token: '{{ $token }}'},
                    statusCode: {
                        204: function (response) {
                            console.log(row);
                            row.fadeOut(750, function () {
                                $(this).remove()
                            });
                        }
                    }
                })
            })
        });
    </script>
    @endcan
@endsection