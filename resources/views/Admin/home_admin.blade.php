@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
       <center> <h1> Aplikasi Presensi Karyawan<BR/> <b>Universitas Catur Insan Cendikia</b> </h1> </center>
      </div>
    </div>
    <br/>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('adminlte/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/raphael/raphael-min.js') }}"></script>
@endsection