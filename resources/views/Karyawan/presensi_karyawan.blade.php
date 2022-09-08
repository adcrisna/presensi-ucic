@extends('layouts.karyawan')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <br/>
        <br/>
        <ol class="breadcrumb">
          <li><a href="{{ route('home_karyawan') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Data Presensi</li>
        </ol>
      </section>
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Presensi</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID Absensi</th>
                  <th>Nomor Induk Pegawai</th>
                  <th>Waktu Absen</th>
                  <th>Status Presensi</th>
                  <th>Foto Wajah</th>
                </tr>
                @foreach($presensi as $key => $value)
                <tr>
                  <td>{{ $value->absensi_id }}</td>
                  <td>{{ $value->nip }}</td>
                  <td>{{ $value->jam_absen }}</td>
                  <td>@if ($value->status_presensi == "Masuk")
                    <span class="label label-success">{{ $value->status_presensi }}</span>
                  @elseif ($value->status_presensi == "Pulang")
                     <span class="label label-warning">{{ $value->status_presensi }}</span>
                  @endif
                 </td>
                 <td><img width="100px" src="{{ asset('foto/'.$value->foto_selfie) }}"></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        
      </section>
      <!-- /.content -->
 @endsection

@section('javascript')

@endsection
