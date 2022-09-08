<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Presensi;
use App\Models\Waktu;

date_default_timezone_set('Asia/Jakarta');

class ApiPresensiController extends Controller
{
    public function insertPresensi(Request $request)
    {
        $tanggal = date("Y-m-d");
        $Jam = date("H:i:s");
        $nip = $request->nip;
        $status = $request->status_presensi;
        $namafoto = "Presensi"." ". $request->nip." ".date("Y-m-d H-i-s");
        //cek device

        $cekDevice = User::where('nip','=',$nip)->where('serial_device','=',$request->serial_device)->first();
        if ($cekDevice) {
            //cek presensi
            $cekPresensi = Presensi::where('nip','=',$nip)->whereDate('jam_presensi','=',$tanggal)->where('status_presensi','=',$status)->first();
            if ($cekPresensi) {
                    return response()->json(array([
                        'status' => 'failed',
                        'apimessage' => "Opppsss...\nAnda Sudah Melakukan Presensi $status Sebelumnya"
                    ]),200);
            }else{
                // cek absen pulang
                if ($request->status_presensi == "Pulang") {
            
                        $cekMasuk = Presensi::where('nip','=',$nip)->whereDate('jam_presensi','=',$tanggal)->where('status_presensi','=','Masuk')->first();
                        if ($cekMasuk) {
                            //insert absen pulang
                            $extention = $request->file('foto_presensi')->extension();
                            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                            $destination = base_path() .'/public/foto';
                            $request->file('foto_presensi')->move($destination,$photo);

                            $absen=array(
                                'nip'=>$request->nip,
                                'status_presensi'=>$request->status_presensi,
                                'foto_presensi'=>$photo,
                                'jam_presensi'=> date("Y-m-d H-i-s")
                            );
                            Presensi::insert($absen);
                                return response()->json(array([
                                    'status' => 'success',
                                    'apimessage' => "Presensi $status Anda Sukses \nJam $Jam\nTerima Kasih"
                                ]),200);
                        }else{
                            return response()->json(array([
                                'status' => 'failed',
                                'apimessage' => "Opppsss...\nAnda Tidak Melakukan Presensi Masuk"
                            ]),200);
                        }
                }else {
                    //insert absen masuk
                    $extention = $request->file('foto_presensi')->extension();
                    $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                    $destination = base_path() .'/public/foto';
                    $request->file('foto_presensi')->move($destination,$photo);

                    $absen=array(
                        'nip'=>$request->nip,
                        'status_presensi'=>$request->status_presensi,
                        'foto_presensi'=>$photo,
                        'jam_presensi'=> date("Y-m-d H-i-s")
                    );
                    Presensi::insert($absen);
                    return response()->json(array([
                            'status' => 'success',
                            'apimessage' => "Presensi $status Anda Sukses \nJam $Jam\nTerima Kasih"
                    ]),200);
                }
            }
        }else{
            return response()->json(array([
                'status' => 'success',
                'apimessage' => "Anda Terdeteksi Menggunakan Perangkat Yang Berbeda!!"
            ]),200);
        }
    }

    public function getHistory($nip, $tanggal)
    {
        $cek_user = User::where('nip',$nip)->first();
        if ($cek_user) {
            $cek_data = Presensi::where('nip', $nip)->whereDate('jam_presensi', $tanggal)->first();
            if ($cek_data != "") {
                $data = Presensi::where('nip', $nip)->whereDate('jam_presensi', $tanggal)->get();
                $data[0]['status'] = "success";
                $data[0]['apimessage'] = "data diterima";
                return response()->json($data,200);
            }else{
                return response()->json(array([
                    'status' => 'failed',
                    'apimessage' => "data presensi tidak ditemukan"
                ]),200);
            }
        }else{
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => "data user tidak ditemukan"
            ]),200);
        }
    }

    public function getJamPresensi()
    {
        $cek_data = Waktu::first();
        if ($cek_data) {
            $data = Waktu::first();
            $data['status'] = "success";
            $data['apimessage'] = "Data Ditemukan";
            return response()->json(array($data),200);
        }else{
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => 'Data Tidak Ditemukan!!'
            ]),200);
        }
    }
}