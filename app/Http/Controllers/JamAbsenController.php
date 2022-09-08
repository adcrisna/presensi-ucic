<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waktu;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JamAbsenController extends Controller
{
    public function jamAbsen()
    {
        $data['title'] = "Waktu Absen";
        $data['nama'] = Auth::user()->nama_user;
        $data['jam_absen'] = Waktu::where('waktupresensi_id','=',1)->first();
        return view('Admin/jam_absen',$data);
    }

    public function updateJamAbsen(Request $request)
    {
        $data=array(
            'batas_masuk'=>$request->jamMasuk,
            'awal_pulang'=>$request->jamKeluar,
        );

        Waktu::where('waktupresensi_id','=',$request->idJamAbsen)->update($data);
        \Session::flash('msg_update_jamAbsen','Waktu Absen Berhasil di Update!');
        return Redirect::route('jam_absen');
    }
}
?>