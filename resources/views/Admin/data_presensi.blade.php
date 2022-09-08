@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <style>
    img.zoom {
      width: 150px;
      height: 120px;
      -webkit-transition: all .2s ease-in-out;
      -moz-transition: all .2s ease-in-out;
      -o-transition: all .2s ease-in-out;
      -ms-transition: all .2s ease-in-out;
    }
    .transisi {
        -webkit-transform: scale(1.8); 
        -moz-transform: scale(1.8);
        -o-transform: scale(1.8);
        transform: scale(1.8);
    }
  </style>
  @endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Data Presensi</li>
    </ol>
    <br/>
  </section>
  <section class="content">
            @if(\Session::has('msg_hapus_data'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_data')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_gagal_hapus'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_gagal_hapus')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Presensi</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-print"><i class="fa fa-print"></i> Cetak Rekap Presensi</button>
                </div>
              </div>
              <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="data-presensi">
                      <thead>
                        <tr>
                          <th style="display: none;" width="75px">ID</th>
                          <th>Foto Presensi</th>
                          <th>Nomor Induk</th>
                          <th>Nama</th>
                          <th>Jam Presensi</th>
                          <th>Status Presensi</th>
                          <th>Aksi</th>       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($presensi as $key => $value)
                        <tr>
                          <td style="display: none;">{{ $value->presensi_id }}</td>
                          <td><img src="{{ asset('foto/'.$value->foto_presensi) }}" class="zoom"></td>
                          <td>{{ $value->nip }}</td>
                          <td>{{ $value->nama_user}}</td>
                              @if ($value->jam_presensi > date("Y-m-d")." "."08:00:00" && $value->status_presensi == "Masuk")
                              <td><span class="label label-danger">{{ $value->jam_presensi }}</span></td>
                              @elseif ($value->jam_presensi <= date("Y-m-d")." "."08:00:00" && $value->status_presensi == "Masuk")
                              <td><span class="label label-success">{{ $value->jam_presensi }}</span></td>
                              @else
                              <td><span class="label label-success">{{ $value->jam_presensi }}</span></td>
                              @endif 
                          <td>{{ $value->status_presensi }}</td>
                          <td>
                            <a href="{{ route('delete_dataPresensi',$value->presensi_id) }}"><button class="btn btn-xs btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')" ><i class="fa fa-trash"> Hapus Presensi</i></button></a> 
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
              </div>
            </div>          
      </div>
    </div>
  </section>
  <div class="modal fade" id="modal-print" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Pilih Periode Laporan</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('print_dataPresensi') }}" method="POST" target="_blank">
          {{ csrf_field() }}
            <div class="form-group has-feedback">
              <label>Dari Tanggal :</label>
              <input type="date" name="tgl_dari" class="form-control" required>
            </div>
            <div class="form-group has-feedback">
              <label>Sampai Tanggal :</label>
              <input type="date" name="tgl_sampai" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-xs-4 col-xs-offset-8">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-print"> </i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
  var table = $('#data-presensi').DataTable();

  $(document).ready(function(){
      $('.zoom').hover(function() {
          $(this).addClass('transisi');
      }, function() {
          $(this).removeClass('transisi');
      });
  });  
</script>
@endsection