<div class="form-group">
    {!! Form::label('label', 'Name') !!}
    {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'My awesome collection', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}