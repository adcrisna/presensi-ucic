@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <style>
    img.zoom {
      width: 180px;
      height: 130px;
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
      <li class="active">Data Izin</li>
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
            @if(\Session::has('msg_update_data_izin'))
           <h5> <div class="alert alert-success">
              {{ \Session::get('msg_update_data_izin')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Izin</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-print"><i class="fa fa-print"></i> Cetak Data Izin</button>
                </div>
              </div>
              <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="data-izin">
                      <thead>
                        <tr>
                          <th style="display: none;" width="75px">ID</th>
                          <th>Bukti Izin</th>
                          <th>Nama</th>
                          <th>Status Izin</th>
                          <th width="130px">Ket. Izin</th>
                          <th>Tgl Izin</th>
                          <th>Tgl Berakhir</th>
                          <th>Approved</th>
                          <th>Catatan</th>
                          <th>Aksi</th>       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($izin as $key => $value)
                        <tr>
                          <td style="display: none;">{{ $value->izin_id }}</td>
                          <td><img width="150px" height="150px" src="{{ asset('foto/'.$value->foto_bukti) }}" class="zoom"></td>
                          <td>{{ $value->nama_user}}</td>
                          <td>{{ $value->status_izin }}</td>
                          <td>{{ $value->keterangan_izin }}</td>
                          <td>{{ $value->tanggal_awal }}</td>
                          <td>{{ $value->tanggal_akhir }}</td>
                          <td>{{ $value->approved }}</td>
                          <td>{{ $value->komentar }}</td>
                          <td width="180px">
                            @if ($value->approved == "Diproses")
                            <a href="{{ route('acc_izin',$value->izin_id) }}"><button class="btn btn-xs btn-success" onclick="return confirm('apakah anda yakin ingin menyetujui izin ini ?')" ><i class="fa fa-check"> Setujui Izin</i></button></a> &nbsp;
                            <button class="btn btn-xs btn-warning btn-edit-izin"><i class="fa fa-edit"> Tolak Izin</i></button>
                            @elseif ($value->approved == "Ditolak")
                            <!-- <a href="{{ route('delete_izin',$value->izin_id) }}"><button class="btn btn-xs btn-danger" onclick="return confirm('apakah anda yakin ingin Menghapus izin ini ?')" ><i class="fa fa-trash"> Hapus Izin</i></button></a> -->
                            <span class="label label-danger">Ditolak</span>
                            @else
                            <span class="label label-info">Disetujui</span>
                            @endif 
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
            <h4 class="modal-title">Pilih Tanggal Laporan</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('print_izin') }}" method="POST" target="_blank">
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
  <div class="modal fade" id="modal-form-edit-izin" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Catatan Tolak Izin </h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('tolak_izin') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="izin_id"  readonly class="form-control" readonly>
          </div>
          <div class="form-group has-feedback">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" cols="5" rows="3"></textarea>
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Kirim</button>
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
  var table = $('#data-izin').DataTable();
  
  $('#data-izin').on('click','.btn-edit-izin',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=izin_id]').val(row[0]);
    $('#modal-form-edit-izin').modal('show');
  });

  $(document).ready(function(){
      $('.zoom').hover(function() {
          $(this).addClass('transisi');
      }, function() {
          $(this).removeClass('transisi');
      });
  });  
</script>
@endsection