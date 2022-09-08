@extends('layouts.karyawan')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_karyawan') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </section>
  <br/>
  <br/>
  <section class="content">
            @if(\Session::has('msg_update_profile'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_update_profile')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_gagal_foto'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal_foto')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
         <div class="box">
          <div class="box-header">
                <h3 class="box-title">Profile Karyawan</h3>
          </div>
          <div class="box-body table-responsive">
            <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="hidden" name="id" readonly class="form-control" value="{{ $karyawan->id }}" readonly>
          </div>
            <div class="form-group has-feedback">
                <label>Nomor Induk Karyawan </label>
                <input type="text" name="nip" class="form-control" value="{{ $karyawan->nip }}" readonly>
            </div>
            <div class="form-group has-feedback">
                <label>Nama :</label>
                <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama_user }}" require>
            </div>
            <div class="form-group has-feedback">
                <label>Email :</label>
                <input type="email" name="email" class="form-control" value="{{ $karyawan->email}}" require>
            </div>
            <div class="form-group has-feedback">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder=" Masukan Password Baru">
            </div>
            <div class="form-group has-feedback">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ $karyawan->nama_jabatan }}" readonly>
            </div>
            <div class="form-group has-feedback">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" cols="10" rows="5">{{ $karyawan->alamat }}</textarea>
            </div>
            <div class="form-group has-feedback">
                <label>foto</label>
                <img width="100px" src="{{ asset('foto/'.$karyawan->foto_user) }}">
                <input type="hidden" name="foto_lama" class="form-control" value="{{ $karyawan->foto_user }}">
                <input type="file" name="foto_baru" class="form-control">
            </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
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
@endsection