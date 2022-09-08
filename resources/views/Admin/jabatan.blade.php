@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Data Jabatan</li>
    </ol>
    <br/>
  </section>
  <section class="content">
           @if(\Session::has('msg_simpan_data'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_data')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_data'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_data')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_update_data'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_update_data')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Jabatan</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-form-tambah-jabatan"><i class="fa fa-plus"> Tambah Jabatan</i></button>
                </div>
              </div>
              <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="data-jabatan">
                      <thead>
                        <tr>
                          <th>ID Jabatan</th>
                          <th>Nama Jabatan</th>
                          <th>Aksi</th>       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($jabatan as $key => $value)
                        <tr>
                          <td>{{ $value->jabatan_id }}</td>
                          <td>{{ $value->nama_jabatan }}</td>
                          <td width="330px">
                            <button class="btn btn-xs btn-success btn-edit-jabatan"><i class="fa fa-edit"> Ubah Jabatan</i></button> &nbsp;
                            <a href="{{ route('delete_jabatan',$value->jabatan_id) }}"><button class="btn btn-xs btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')" ><i class="fa fa-trash"> Hapus Jabatan</i></button></a> 
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
  <div class="modal fade" id="modal-form-tambah-jabatan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Jabatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('tambah_jabatan') }}" method="post">
            {{ csrf_field() }}

          <div class="form-group has-feedback">
            <input type="text" name="namaJabatan" class="form-control" placeholder="Nama Jabatan">
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
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
    <div class="modal fade" id="modal-form-edit-jabatan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Edit Kecamatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('update_jabatan') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="idJabatan"  readonly class="form-control" placeholder=" ID Jabatan">
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="namaJabatan" class="form-control" placeholder="Nama Jabatan">
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
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
  var table = $('#data-jabatan').DataTable();

  $('#data-jabatan').on('click','.btn-edit-jabatan',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=idJabatan]').val(row[0]);
    $('input[name=namaJabatan]').val(row[1]);
    $('#modal-form-edit-jabatan').modal('show');
  });

  $('#modal-form-tambah-jabatan').on('show.bs.modal',function(){
    $('input[name=namaJabatan]').val('');
  });
</script>
@endsection