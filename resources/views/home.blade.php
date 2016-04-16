@extends('layouts.app')

<?php $token = csrf_token() ?>

@section('head')
    <title>Profile for: {{ $user->name }}</title>
    @can('edit', $user)
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
          rel="stylesheet"/>
    @endcan
@endsection

@section('content')
    <div class="page-heading">
        <h1>Your dashboard</h1>
    </div>

    <div class="row">

        <!-- Profile Editor -->
        <div class="col-xs-12 col-sm-6">
            <h2>Your Profile</h2>
            <hr />
            <ul>
                <li>
                    Name:
                    <span data-type="text" data-pk="{{ $user->slug }}" data-name="name"
                          data-url="{{ route('users.update', $user->slug) }}" data-title="Name" class="editable">
                        {{ $user->name }}
                    </span></li>
                <li>
                    Email:
                    <span data-type="text" data-pk="{{ $user->slug }}" data-name="email"
                          data-url="{{ route('users.update', $user->slug) }}" data-title="Email" class="editable">
                    {{ $user->email }}
                    </span>
                </li>
            </ul>
        </div>

        <!-- Collection List -->
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your model collections
                </div>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Progress</th>
                        <th>Last Updated</th>
                    </tr>
                    @foreach($user->collections as $collection)
                        <tr>
                            <td>
                                <a href="{{ route('collections.show', $collection->slug) }}">
                                    {{ $collection->label }}
                                </a>
                            </td>
                            <td>
                                {{ $collection->size }}
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{$collection->progress}}%">
                                        <span class="sr-only">{{ $collection->progress}}% complete</span>
                                    </div>
                                </div>
                            </td>
                            <th>{{ $collection->updated_at->diffForHumans() }}</th>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('endBody')
    @can('edit', $user)
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script>
        $(function() {
            $.fn.editable.defaults.ajaxOptions = {method: 'PATCH'};
            $(".editable").editable({
                params: function (params) {
                    var data = {};
                    data['id'] = params.pk;
                    data[params.name] = params.value;
                    data['_token'] = '{{ $token }}';
                    return data;
                },
            });
        })
    </script>
    @endcan
@endsection
