@extends('template')

@section('main')
    <div id="warga">
        <h2>Tambah Warga</h2>

        {!! Form::open(['url' => 'warga', 'files' => true]) !!}
            @include('warga.form', ['submitButtonText' => 'Tambah Warga'])
        {!! Form::close() !!}
    </div>
@stop

@section('footer')
    @include('footer')
@stop