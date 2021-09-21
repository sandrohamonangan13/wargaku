@extends('template')

@section('main')
    <div id="cluster">
        <h2>Tambah Cluster</h2>

        {!! Form::open(['url' => 'cluster']) !!}
            @include('cluster.form', ['submitButtonText' => 'Tambah Cluster'])
        {!! Form::close() !!}
    </div>
@stop

@section('footer')
    @include('footer')
@stop