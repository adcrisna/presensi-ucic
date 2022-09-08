@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte//bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Waktu Presensi</li>
    </ol>
  </section>
  <section class="content">
            @if(\Session::has('msg_update_jamAbsen'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_update_jamAbsen')}}
            </div></h5>
            @endif
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8">
            <div class="box">
                <div class="box-header">
                        <h3 class="box-title">Waktu Presensi</h3>
                </div>
                <div class="box-body table-responsive">
                    <form action="{{ route('update_jamAbsen') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="idJamAbsen" class="form-control" value="{{ $jam_absen->waktupresensi_id }}" readonly>
                        </div>
                            <div class="form-group has-feedback">
                            <label>Batas Jam Masuk </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="number" name="jamMasuk" class="form-control pull-right" value="{{ $jam_absen->batas_masuk }}" required>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Awal Jam Pulang</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="number" name="jamKeluar" class="form-control pull-right" value="{{ $jam_absen->awal_pulang }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-5">
                            <button type="submit" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-edit"></i> Ubah Waktu Presensi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>
    <br/>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('adminlte/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('adminlte/\/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
@endsection