@if (isset($warga))
    {!! Form::hidden('id', $warga->id) !!}
@endif


<!-- nik -->
@if ($errors->any())
<div class="form-group {{ $errors->has('nik') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
     {!! Form::label('nik', 'NIK:', ['class' => 'control-label']) !!}
     {!! Form::text('nik', null, ['class' => 'form-control']) !!}
     @if ($errors->has('nik'))
        <span class="help-block">{{ $errors->first('nik') }}</span>
     @endif
</div>


<!-- NAMA -->
@if ($errors->any())
<div class="form-group {{ $errors->has('nama_warga') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
     {!! Form::label('nama_warga', 'Nama:', ['class' => 'control-label']) !!}
     {!! Form::text('nama_warga', null, ['class' => 'form-control']) !!}
     @if ($errors->has('nama_warga'))
        <span class="help-block">{{ $errors->first('nama_warga') }}</span>
     @endif
</div>


<!-- TANGGAL LAHIR -->
@if ($errors->any())
<div class="form-group {{ $errors->has('tanggal_lahir') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
    {!! Form::label('tanggal_lahir', 'Tanggal Lahir:', ['class' => 'control-label']) !!}
    {!! Form::date('tanggal_lahir', !empty($warga) ? $warga->tanggal_lahir->format('Y-m-d'): null, ['class' => 'form-control', 'id' => 'tanggal_lahir']) !!}
    @if ($errors->has('tanggal_lahir'))
        <span class="help-block">{{ $errors->first('tanggal_lahir') }}</span>
    @endif
</div>


<!-- cluster -->
@if ($errors->any())
    <div class="form-group {{ $errors->has('id_cluster') ? 'has-error' : 'has-success' }}">
@else
    <div class="form-group">
@endif
    {!! Form::label('id_cluster', 'Cluster:', ['class' => 'control-label']) !!}
    @if(count($list_cluster) > 0)
        {!! Form::select('id_cluster', $list_cluster, null, ['class' => 'form-control', 'id' => 'id_cluster', 'placeholder' => 'Pilih cluster']) !!}
     @else
       <p>Tidak ada pilihan cluster, buat dulu ya...!</p>
   @endif
   @if ($errors->has('id_cluster'))
       <span class="help-block">{{ $errors->first('id_cluster') }}</span>
   @endif
</div>


<!-- JENIS KELAMIN -->
@if ($errors->any())
<div class="form-group {{ $errors->has('jenis_kelamin') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
    {!! Form::label('jenis_kelamin', 'Jenis Kelamin:', ['class' => 'control-label']) !!}
    <div class="radio">
        <label>{!! Form::radio('jenis_kelamin', 'L') !!} Laki-laki</label>
    </div>
    <div class="radio">
        <label>{!! Form::radio('jenis_kelamin', 'P') !!} Perempuan</label>
    </div>
    @if ($errors->has('jenis_kelamin'))
        <span class="help-block">{{ $errors->first('jenis_kelamin') }}</span>
     @endif
</div>


<!-- TELEPON -->
@if ($errors->any())
<div class="form-group {{ $errors->has('nomor_telepon') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
    {!! Form::label('nomor_telepon', 'Telepon:', ['class' => 'control-label']) !!}
    {!! Form::text('nomor_telepon', null, ['class' => 'form-control']) !!}
    @if ($errors->has('nomor_telepon'))
    <span class="help-block">{{ $errors->first('nomor_telepon') }}</span>
    @endif
</div>


<!-- HOBI -->
@if ($errors->any())
<div class="form-group {{ $errors->has('hobi_warga') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
{!! Form::label('hobi_warga', 'Hobi:', ['class' => 'control-label']) !!}
@if(count($list_hobi) > 0)
    @foreach($list_hobi as $key => $value)
        <div class="checkbox">
            <label>{!! Form::checkbox('hobi_warga[]', $key, null) !!} {{ $value }}</label>
        </div>
    @endforeach
@else
    <p>Tidak ada pilihan hobi, buat dulu ya...!</p>
@endif
</div>

<!-- FOTO -->
@if ($errors->any())
<div class="form-group {{ $errors->has('foto') ? 'has-error' : 'has-success' }}">
@else
<div class="form-group">
@endif
    {!! Form::label('foto', 'Foto:') !!}
    {!! Form::file('foto') !!}
    @if ($errors->has('foto'))
        <span class="help-block">{{ $errors->first('foto') }}</span>
    @endif

    <!-- MENAMPILKAN FOTO -->
    @if (isset($warga))
        @if (isset($warga->foto))
            <img src="{{ asset('fotoupload/' . $warga->foto) }}">
        @else
            @if ($warga->jenis_kelamin == 'L')
                <img src="{{ asset('fotoupload/dummymale.jpg') }}">
            @else
                <img src="{{ asset('fotoupload/dummyfemale.jpg') }}">
            @endif
        @endif
    @endif
</div>

<!-- SUBMIT -->
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>