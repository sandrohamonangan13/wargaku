@extends('template')

@section('main')
    <div id="cluster">
    <h2>Edit Cluster</h2>

    {!! Form::model($cluster, ['method' => 'PATCH', 'action' => ['ClusterController@update', $cluster->id]]) !!}
        @include('cluster.form', ['submitButtonText' => 'Update Cluster'])
    {!! Form::close() !!}
    </div>
@stop

@section('footer')
    @include('footer')
@stop