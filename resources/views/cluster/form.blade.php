@if (isset($cluster))
    {!! Form::hidden('id', $cluster->id) !!}
@endif

@if ($errors->any())
    <div class="form-group {{ $errors->has('nama_cluster') ? 'has-error' : 'has-success' }}">
@else
     <div class="form-group">
@endif
    {!! Form::label('nama_cluster', 'Nama Cluster:', ['class' => 'control-label']) !!}
    {!! Form::text('nama_cluster', null, ['class' => 'form-control']) !!}
    @if ($errors->has('nama_cluster'))
        <span class="help-block">{{ $errors->first('nama_cluster') }}</span>
    @endif
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>