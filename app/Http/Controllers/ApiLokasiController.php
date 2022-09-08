<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lokasi;

class ApiLokasiController extends Controller
{
    public function getLokasi()
    {
        $cek_data = Lokasi::first();
        if ($cek_data) {
            $data = Lokasi::first();
            $data['status'] = "success";
            $data['apimessage'] = "Lokasi Terdaftar Diterima";
            return response()->json(array($data),200);
        }else{
            return response()->json(array([
                'status' => "failed",
                'apimessage' => 'Lokasi Terdaftar Tidak Ditemukan'
            ]),200);
        }
    }
}
