<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ asset('cic.png') }}" type="image/x-icon" />
  <title>{{ $title }}</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">

  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css') }}">

  @yield('css')
</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <div class="navbar-brand"><b>Universitas </b> CIC</div>
        </div>

        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="{{ route('home_karyawan') }}">Home <span class="sr-only">(current)</span></a></li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="{{ route('presensi_karyawan') }}"><i class="fa fa-list"></i>
                <span class="hidden-xs ">Data History Absensi</span>
              </a>
            </li>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <i class="fa fa-user"></i><span class="hidden-xs ">{{ $nama }}</span>
              </a>
                 <ul class="dropdown-menu">
                <li class="user-footer">
                    <a class="button" href="{{ route('profile_karyawan') }}" class="btn btn-default btn-flat"><i class="fa fa-gear"></i>Profile</a><br/>
                    <a class="button" href="{{ route('logout_karyawan') }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i>Sign out</a> 
                </li>
            </li>
        </div>
      </div>

    </nav>
  </header>

  <div class="content-wrapper">
    <div class="container">
      @yield('content')
    </div>
  </div>
  <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Build with <span class="fa fa-coffee"></span> And <span class="fa fa-heart"></b>
      </div>
      <strong>@adcrisna_ &copy; 2021</strong>
  </footer>
</div>

<script src="{{ asset('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/app.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
@yield('javascript')
</body>
</html>
