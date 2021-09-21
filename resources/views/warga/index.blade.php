 @extends('template')

 @section('main')
     <div id="warga">
         <h2>Warga</h2>

         @include('_partial.flash_message')

         @include('warga.form_pencarian')

         @if (!empty($warga_list))
             <table class="table">
                 <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Cluster</th>
                        <th>Tgl Lahir</th>
                        <th>JK</th>
                        <th>Telepon</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warga_list as $warga)
                    <tr>
                        <td>{{ $warga->nik }}</td>
                        <td>{{ $warga->nama_warga }}</td>
                        <td>{{ $warga->cluster->nama_cluster }}</td>
                        <td>{{ $warga->tanggal_lahir->format('d-m-Y') }}</td>
                        <td>{{ $warga->jenis_kelamin }}</td>
                        <td>{{ !empty($warga->telepon->nomor_telepon) ? $warga->telepon->nomor_telepon : '-' }}</td>
                        <td>
                            <div class="box-button">
                                {{ link_to('warga/' . $warga->id, 'Detail', ['class' => 'btn btn-success btn-sm']) }}
                            </div>

                            @if (Auth::check())
                            <div class="box-button">
                                {{ link_to('warga/' . $warga->id . '/edit', 'Edit', ['class' => 'btn btn-warning btn-sm']) }}
                            </div>
                            <div class="box-button">
                                {!! Form::open(['method' => 'DELETE', 'action' => ['WargaController@destroy', $warga->id]]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>Tidak ada data warga.</p>
            @endif

        <div class="table-nav">
             <div class="jumlah-data">
                 <strong> Jumlah Warga: {{ $jumlah_warga }} </strong>
             </div>
             <div class="paging">
                {{ $warga_list->links() }}
            </div>
        </div>

        @if (Auth::check())
        <div class="tombol-nav">
            <a href="{{ url('warga/create') }}" class="btn btn-primary">Tambah Warga</a>
        </div>
        @endif

    </div> <!-- / #warga -->
@stop


@section('footer')
    @include('footer')
@stop
