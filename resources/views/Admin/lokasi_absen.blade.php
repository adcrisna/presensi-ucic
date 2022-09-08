@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Lokasi Presensi</li>
    </ol>
  </section>
  <section class="content">
        @if(\Session::has('msg_update_LokasiAbsen'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_update_LokasiAbsen')}}
            </div></h5>
            @endif
    <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8">
            <div class="box">
                <div class="box-header">
                        <h3 class="box-title">Lokasi Presensi</h3>
                </div>
                <div class="box-body table-responsive">
                    <form action="{{ route('update_lokasiAbsen') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="idLokasi" class="form-control" value="{{ $lokasi->lokasi_id }}" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="hidden" name="nip" class="form-control" value="{{ $lokasi->nip }}" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Lokasi</label>
                            <input type="text" name="namaLokasi" class="form-control" value="{{ $lokasi->nama_lokasi }}" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Toleransi (meter)</label>
                            <input type="number" name="toleransi" class="form-control" value="{{ $lokasi->toleransi }}" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Masukan Lokasi Baru :</label>
                            <div id="gMap" style="width:100%;height:400px;"></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label>Latitude :</label>
                                    <input type="text"  name="latitude" id="latitude" class="form-control" value="{{ $lokasi->latitude }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label>Logitude :</label>
                                    <input type="text"  name="longitude" id="longitude" class="form-control" value="{{ $lokasi->longitude }}" readonly>
                                </div>
                            </div>
                        <div class="row">
                        <div class="col-md-5"></div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-edit"></i> Ubah Lokasi Presensi</button>
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
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
  
function initialize() {
  var lati = parseFloat(document.getElementById("latitude").value) ;
      var long = parseFloat(document.getElementById("longitude").value) ;
    console.log(lati,long);
     var info_window = new google.maps.InfoWindow();

     // menentukan level zoom
     var zoom = 16;

     // menentikan latitude dan longitude
     var pos = new google.maps.LatLng({lat: lati, lng: long});

     // menentukan opsi peta
     var options = {
      'center': pos,
      'zoom': zoom,
      'mapTypeId': google.maps.MapTypeId.ROADMAP
     };

     // membuat peta
     var map = new google.maps.Map(document.getElementById('gMap'), options);
     info_window = new google.maps.InfoWindow({
      'content': 'loading...'
     });

     // membuat marker
     var marker = new google.maps.Marker({
      position: pos,
      title: 'here',
      
     });

     // set marker di peta
     marker.setMap(map);

     function taruhMarker(peta, posisiTitik){
    
    if( marker ){
      // pindahkan marker
      marker.setPosition(posisiTitik);
    } else {
      // buat marker baru
      marker = new google.maps.Marker({
        position: posisiTitik,
        map: peta
      });
    }
  
     // isi nilai koordinat ke form
    document.getElementById("latitude").value = posisiTitik.lat();
    document.getElementById("longitude").value = posisiTitik.lng();
    
}

  // even listner ketika peta diklik
  google.maps.event.addListener(map, 'click', function(event) {
    taruhMarker(this, event.latLng);
  });

}
  
// event jendela di-load  
google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection