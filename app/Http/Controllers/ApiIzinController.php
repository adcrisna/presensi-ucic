<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Presensi;
use App\Models\Waktu;
use App\Models\Izin;
use DateTime;

class ApiIzinController extends Controller
{
    public function insertIzin(Request $request)
    {
        $namafoto = "Bukti Izin"." ". $request->nip." ".date("Y-m-d H-i-s");
        if (empty($request->foto_bukti)) {
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => "Masukan foto bukti izin"
            ]),200);
        }else{
            $extention = $request->file('foto_bukti')->extension();
            $bukti = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/foto';
            $request->file('foto_bukti')->move($destination,$bukti);

            $awal_date = $request->tanggal_awal;
            $akhir_date = $request->tanggal_akhir;
            $datetime1 = new DateTime($awal_date);
            $datetime2 = new DateTime($akhir_date);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            $izin=array(
                'nip'=>$request->nip,
                'tanggal_awal'=>$request->tanggal_awal,
                'tanggal_akhir'=>$request->tanggal_akhir,
                'lama_izin'=>$days,
                'status_izin'=>$request->status_izin,
                'keterangan_izin'=>$request->keterangan_izin,
                'foto_bukti'=>$bukti,
                'approved'=>"Diproses",
                'komentar'=>"-"
            );
            Izin::insert($izin);
            return response()->json(array([
                'status' => 'success',
                'apimessage' => "Izin Berhasil Diajukan"
            ]),200);
        }
    }

    public function getHistoryIzin($nip)
    {
        $cek_user = User::where('nip',$nip)->first();

        if ($cek_user) {
            $dataIzin = Izin::where('nip',$nip)->first();
            if ($dataIzin != "") {
                $data = Izin::leftJoin('users','izin.nip','=','users.nip')->where('izin.nip',$nip)->orderByRaw('izin_id DESC')->get();
                $data[0]['status'] = "success";
                $data[0]['apimessage'] = "Data Diterima";
                return response()->json($data,200);
            }else{
                return response()->json(array([
                    'status' => 'failed',
                    'apimessage' => "data izin tidak ditemukan"
                ]),200);
            }
        }else{
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => "data user tidak ada"
            ]),200);
        }
    }
}
