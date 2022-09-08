@extends('layouts.karyawan')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <br/>
        <br/>
        <ol class="breadcrumb">
          <li><a href="{{ route('home_karyawan') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>

      <section class="content">
          <div class="col-md-12">
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  <img src="{{ asset('cic.png') }}" alt="logo_cic">
                  <span class="username"><a href="#">Informasi</a></span>
                  <span class="description">Admin, Universitas Catur Insan Cendikia</span>
                </div>
                <div class="box-tools"> 
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive">
                <h4>Selamat Datang</h4><br/>
                <p></p>


              </div>
            </div>
          </div>
      </section>
 @endsection

@section('javascript')

@endsection
