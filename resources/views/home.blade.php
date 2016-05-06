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
    <div class="page-header">
        <h1>Your dashboard</h1>
    </div>

    <div class="row">

        <!-- Profile Editor -->
        <div class="col-xs-12 col-sm-4">
            <h2>Your Profile</h2>
            <ul class="list-unstyled">
                <li>
                    <img src="http://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=180" alt=""
                         class="img-rounded profile-image" />
                </li>
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
        <div class="col-xs-12 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your model collections
                </div>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Progress</th>
                        <th>Last Updated</th>
                        <th>Delete?</th>
                    </tr>
                    @foreach($user->collections as $collection)
                        <tr>
                            <td>
                                <a href="{{ route('collections.show', $collection->slug) }}">
                                    {{ $collection->label }}
                                </a>
                            </td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{$collection->progress}}%">
                                        <span class="sr-only">{{ $collection->progress}}% complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $collection->updated_at->diffForHumans() }}</td>
                            <td>
                                <span data-url="{{ route('collections.destroy', $collection->slug) }}"
                                      class="btn btn-danger confirm destroy btn-xs">
                                    <span class="fa fa-fw fa-trash"></span>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <a href="{{ route('collections.create') }}" class="btn btn-primary">
                                    Create a new collection
                                </a>
                            </td>
                        </tr>
                    </tfoot>
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

            $('tbody').delegate('.confirm.destroy', 'click', function (event) {
                if (!confirm('Are you sure?')) {
                    return;
                }
                var deleteThis = $(this).closest('tr');
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: {_token: '{{ $token }}'},
                    statusCode: {
                        204: function (response) {
                            deleteThis.fadeOut(750, function () {
                                $(this).remove()
                            });
                        }
                    }
                })
            });
        })
    </script>
    @endcan
@endsection
