@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
  <style>
    img.zoom {
      width: 130px;
      height: 100px;
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
      <li class="active">Data Karyawan</li>
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
            @if(\Session::has('msg_gagal'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_gagal_foto'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal_foto')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Karayawan</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-form-tambah-karyawan"><i class="fa fa-user-plus"> Tambah Akun Karyawan </i></button>
                  </div>
              </div>
              <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped" id="data-karyawan">
                      <thead>
                        <tr>
                          <th style="display: none;" width="10">ID</th>
                          <th>Foto</th>
                          <th style="display: none;">Nama Foto</th>
                          <th width="60px" >Nomor Induk</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>NO. HP</th>
                          <th>Alamat</th>
                          <th>Jabatan</th>
                          <th style="display: none;">Serial Device </th>
                          <th style="display: none;">ID Jabatan </th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($karyawan as $key => $value)
                        <tr>
                            <td style="display: none;">{{ $value->id }}</td>
                            <td><img class="zoom" src="{{ asset('foto/'.$value->foto_user) }}"></td>
                            <td style="display: none;">{{ $value->foto_user }}</td>
                            <td>{{ $value->nip }}</td>
                            <td>{{ $value->nama_user }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->no_hp }}</td>
                            <td>{{ $value->alamat }}</td>
                            <td>{{ $value->nama_jabatan }}</td>
                            <td style="display: none;">{{ $value->serial_device }}</td>
                            <td style="display: none;">{{ $value->jabatan_id }}</td>
                            <td>
                                <button class="btn btn-xs btn-success btn-edit-karyawan"><i class="fa fa-edit"> Ubah Akun</i></button> &nbsp;
                                <a href="{{ route('delete_karyawan',$value->id) }}"><button class=" btn btn-xs btn-danger" onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i class="fa fa-trash"> Hapus Akun</i></button></a>
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
  <div class="modal fade" id="modal-form-tambah-karyawan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Karyawan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('tambah_karyawan') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
              <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Karyawan" required>
            </div>
            <div class="form-group has-feedback">
              <input type="text" name="namaUser" class="form-control" placeholder="Nama Karyawan" required>
            </div>
            <div class="form-group has-feedback">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group has-feedback">
              <input type="text" name="no_hp" class="form-control" placeholder="No Handphone" required>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Masukan Password Baru" required>
            </div>
            <div class="form-group has-feedback">
              <label for="alamat">Alamat:</label>
              <textarea name="alamat" cols="5" rows="5" class="form-control" required></textarea>
            </div>
            <div class="form-group has-feedback">
              <label for="id_jabatan">Jabatan :</label>
              <select class="form-control" id="nama_jabatan" name="nama_jabatan">
                @foreach($jabatan as $key => $value)
                <option value="{{ $value->nama_jabatan }}" data-id="{{ $value->jabatan_id }}">{{ $value->nama_jabatan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group has-feedback">
              <input type="hidden" name="id_jabatan"  id="id_jabatan" class="form-control"  readonly required>
            </div>
            <div class="form-group has-feedback">
              <label for="fotoUser">Foto:</label>
              <input type="file" name="fotoUser" class="form-control" required>
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
  <div class="modal fade" id="modal-form-edit-karyawan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Update Karyawan</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('update_karyawan') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
              <input type="text" name="id"  readonly class="form-control" placeholder=" ID Karyawan ">
            </div>
            <div class="form-group has-feedback">
              <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Karyawan">
            </div>
            <div class="form-group has-feedback">
              <input type="text" name="namaUser" class="form-control" placeholder="Nama Karyawan">
            </div>
            <div class="form-group has-feedback">
              <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group has-feedback">
              <input type="text" name="no_hp" class="form-control" placeholder="No Handphone">
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Masukan Password Baru">
            </div>
            <div class="form-group has-feedback">
              <textarea name="alamat" cols="5" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group has-feedback">
                <label for="id_jabatan_edit">Jabatan :</label>
                <select class="form-control" id="nama_jabatan_edit" name="nama_jabatan_edit">
                  @foreach($jabatan as $key => $value)
                  <option value="{{ $value->nama_jabatan }}" data-id_edit="{{ $value->jabatan_id }}">{{ $value->nama_jabatan }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group has-feedback">
            <label>Serial Device:</label>
              <input type="text" name="serial_device" class="form-control">
            </div>
            <div class="form-group has-feedback">
                <input type="hidden" name="id_jabatan"  id="id_jabatan_edit" class="form-control"  readonly required>
            </div>
            <div class="form-group has-feedback">
              <label>Foto Baru:</label>
                <input type="file" name="foto_baru" class="form-control" >
              </div>
              <div class="form-group has-feedback">
                <input type="hidden" name="foto_lama" class="form-control" readonly>
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
  var table = $('#data-karyawan').DataTable();

  $('#data-karyawan').on('click','.btn-edit-karyawan',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id]').val(row[0]);
    $('input[name=foto_lama]').val(row[2]);
    $('input[name=nip]').val(row[3]);
    $('input[name=namaUser]').val(row[4]);
    $('input[name=email]').val(row[5]);
    $('input[name=no_hp]').val(row[6]);
    $('textarea[name=alamat]').val(row[7]);
    $('select[name=nama_jabatan_edit]').val(row[8]);
    $('input[name=serial_device]').val(row[9]);
    $('input[name=id_jabatan]').val(row[10]);
    $('#modal-form-edit-karyawan').modal('show');
  });
  $('#modal-form-tambah-karyawan').on('show.bs.modal',function(){
    $('input[name=id]').val('');
    $('input[name=nip]').val('');
    $('input[name=foto_lama]').val('');
    $('input[name=namaUser]').val('');
    $('input[name=email]').val('');
    $('input[name=no_hp]').val('');
    $('textarea[name=alamat]').val('');
    $('input[name=nama_jabatan]').val('');
    $('input[name=serial_device]').val('');
    $('input[name=id_jabatan]').val('');
  });

  $('#nama_jabatan').change(function(){
      $('#id_jabatan').val($(this).find("option:selected").data('id') );
    });
  
    $('#nama_jabatan_edit').change(function(){
      $('#id_jabatan_edit').val($(this).find("option:selected").data('id_edit') );
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