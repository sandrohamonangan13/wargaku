@extends('template')

@section('main')
    <div id="warga">
        <h2>Edit Warga</h2>

        {!! Form::model($warga, ['method' => 'PATCH', 'files' => true, 'action' => ['WargaController@update', $warga->id]]) !!}
            @include('warga.form', ['submitButtonText' => 'Update Warga'])
        {!! Form::close() !!}
    </div>
@stop

@section('footer')
    @include('footer')
@stop