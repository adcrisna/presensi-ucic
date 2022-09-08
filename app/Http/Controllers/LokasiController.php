<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Lokasi;
use Redirect;

class LokasiController extends Controller
{
    public function lokasiAbsen()
    {
        $data['title'] = "Lokasi Absen";
        $data['nama'] = Auth::user()->nama_user;
        $data['lokasi'] = Lokasi::where('lokasi_id','=',1)->first();
        return view('Admin/lokasi_absen',$data);
    }

    public function updateLokasiAbsen(Request $request)
    {
        $data=array(
            'nama_lokasi'=>$request->namaLokasi,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'toleransi'=>$request->toleransi,
            'nip'=>$request->nip,
        );

        Lokasi::where('lokasi_id','=',$request->idLokasi)->update($data);
        \Session::flash('msg_update_LokasiAbsen','Lokasi Absen Berhasil di Update!');
        return Redirect::route('lokasi_absen');
    }
}
?>