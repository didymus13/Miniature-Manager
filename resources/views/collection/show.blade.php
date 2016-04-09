@extends('layouts.app')

<?php $token = csrf_token() ?>

@section('head')
    <title>{{ ucfirst($collection->label) }}</title>
    <meta name="blurb" content="{{ $collection->description }}"/>
    <meta name="keywords" content="{{ implode(',', $collection->tagNames()) }}">
    <meta property="og:title" content="{{ ucfirst($collection->label) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('collections.show', $collection->slug, true) }}" />

    @if($collection->featuredImage)
        <meta property="og:image" content="{{ url('/uploads/' . $collection->featuredImage->url) }}" />
    @endif

    <link rel="canonical" href="{{ route('collections.show', $collection->slug, true) }}"/>
    @can('edit', $collection)
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/vendor/dropzone/dropzone.min.css">
    @endcan

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.17/css/lightgallery.min.css">
@endsection

@section('content')
    @can('delete', $collection)
    {!! Form::open(['route' => ['collections.destroy', $collection->slug], 'method' => 'DELETE']) !!}
    <div class="pull-right">
        {!! Form::submit('Delete Collection', ['class' => 'btn btn-danger confirm']) !!}
    </div>
    {!! Form::close() !!}
    @endcan
    <article>
    <div class="page-heading">
        <h1 data-type="text" data-pk="{{ $collection->slug }}" data-name="label"
            data-url="{{ route('collections.update', $collection->slug) }}" data-title="Name" class="editable">
            {{ $collection->label }}
        </h1>
    </div>

    <ul class="list-inline">
        <li><span class="fa fa-user"></span></li>
        <li>{{ $collection->user->name }}</li>
        <li><span class="fa fa-calendar"></span> {{ $collection->updated_at->diffForHumans() }}</li>

        @cannot('edit', $collection)
        @if($collection->tags)
            <li><span class="fa fa-tags"></span></li>
            @foreach($collection->tags as $tag)
                <li><a href="{{ route('collections.index', ['tags' => $tag->slug]) }}">{{ $tag->name }}</a></li>
            @endforeach
        @endif
        @endcannot
    </ul>

    @can('edit', $collection)
    {!! Form::label('tags', 'Tags') !!}
    <select multiple="multiple" class="form-control select" name="tags"
            data-url="{{ route('collections.update', $collection->slug) }}">
        @foreach(\App\Collection::existingTags() as $tag)
            <option value="{{ $tag->name }}"
                    @if(in_array($tag->name, $collection->tagNames())) selected="selected" @endif
            >
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    @endcan

    <p data-type="textarea" data-pk="{{ $collection->slug }}" data-name="description"
       data-url="{{ route('collections.update', $collection->slug) }}" data-title="Name" class="editable">
        {{ $collection->description }}
    </p>

    <!-- photo Gallery -->
    <div id="photo-gallery" class="hidden">
        @foreach($collection->miniatures as $miniature)
            @foreach($miniature->photos as $photo)
                    <a href="/uploads/{{ $photo->url }}" class="img-thumbnail">
                        <img src="/uploads/{{ $photo->thumb_url }}" alt="{{ $photo->caption }}" />
                    </a>
            @endforeach
        @endforeach
    </div>

    <!-- Minitures list -->
        <div class="table-responsive">
    <table class="table">
        <caption>Miniatures</caption>
        <thead>
        <tr>
            <th>Name</th>
            <th>Progress</th>
            <th>Thumbnails</th>
            @can('edit', $collection)
            <th>Image Upload</th>
            @endcan
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
                <td>
                    <div class="row">
                    @foreach($mini->photos as $photo)
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                        <img src="/uploads/{{$photo->thumb_url}}" alt="{{ $photo->caption }}"
                             class="img-responsive confirm destroy" data-url="{{ route('photos.destroy', $photo->id) }}"/>
                        </div>
                    @endforeach
                    </div>
                </td>
                @can('edit', $mini)
                <td>
                    {!! Form::open(['method' => 'POST', 'route' => ['miniatures.photos', $mini->slug], 'class' => 'dropzone']) !!}
                    {!! Form::close() !!}
                </td>
                @endcan
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
        </div>
    </article>

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.17/js/lightgallery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.17/js/lg-thumbnail.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.17/js/lg-zoom.min.js"></script>
    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
    <script>
        $(function() {
            $('#photo-gallery').lightGallery({
                thumbnail: true
            });
        })
        $('#photo-gallery').removeClass('hidden');
    </script>
    @can('edit', $collection)
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/i18n/en.js"></script>
    <script src="/vendor/dropzone/dropzone.min.js"></script>
    <script>
        $(function () {
            $('.select').select2({
                tags: true
            });
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
                var deleteThis = $(this).closest('tr');
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    data: {_token: '{{ $token }}'},
                    statusCode: {
                        204: function (response) {
                            console.log(row);
                            deleteThis.fadeOut(750, function () {
                                $(this).remove()
                            });
                        }
                    }
                })
            });

            $('.select').on('change', function (event) {
                console.log($(this).val());
                $.ajax({
                    url: $(this).data('url'),
                    type: 'PUT',
                    data: {_token: '{{ $token }}', tags: $(this).val()}
                });
            });
        });
    </script>
    @endcan
@endsection