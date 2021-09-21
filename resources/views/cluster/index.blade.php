 @extends('template')

 @section('main')
     <div id="cluster">
         <h2>Cluster</h2>

         @include('_partial.flash_message')

         @if (count($cluster_list) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cluster</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach($cluster_list as $cluster): ?>
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $cluster->nama_cluster }}</td>
                        <td>
                            <div class="box-button">
                                {{ link_to('cluster/' . $cluster->id . '/edit', 'Edit', ['class' => 'btn btn-warning btn-sm']) }}
                            </div>
                            <div class="box-button">
                                {!! Form::open(['method' => 'DELETE', 'action' => ['ClusterController@destroy', $cluster->id]]) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        @else
            <p>Tidak ada data cluster.</p>
        @endif

        <div class="tombol-nav">
            <a href="cluster/create" class="btn btn-primary">Tambah Cluster</a>
        </div>

    </div> <!-- / #cluster -->
@stop

@section('footer')
   @include('footer')
@stop