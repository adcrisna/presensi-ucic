<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ApiUserController extends Controller
{
    public function loginUser($nip, $password, $serialdevice)
    {
        $cek_user = User::where('nip','=',$nip)->first();

        if (empty($cek_user->serial_device)) {
            $data = array(
                'serial_device'=>$serialdevice
            );
            User::where('id','=',$cek_user->id)->update($data);

            if (Auth::attempt(['nip'=>$nip,'password'=>$password]))
            {
                $data = User::where('nip','=',$nip)->join('jabatan','users.jabatan_id','=','jabatan.jabatan_id')->first();
                $data['status'] = "success";
                $data['apimessage'] = "Selamat Datang";
                return response()->json(array($data),200);
            }else{
                return response()->json(array([
                    'status' => 'failed',
                    'apimessage' => 'NIP Atau Password Salah!!'
                ]),200);
            }
        }else{
            $cekDevice = User::where('nip','=',$nip)->first();

            if($serialdevice == $cekDevice->serial_device){
                if (Auth::attempt(['nip'=>$nip,'password'=>$password]))
                {
                    $data = User::where('nip','=',$nip)->join('jabatan','users.jabatan_id','=','jabatan.jabatan_id')->first();
                    $data['status'] = "success";
                    $data['apimessage'] = "Selamat Datang";
                    return response()->json(array($data),200);
                }else{
                    return response()->json(array([
                        'status' => 'failed',
                        'apimessage' => 'NIP Atau Password Salah!!'
                    ]),200);
                }
            }else{
                return response()->json(array([
                    'status' => 'failed',
                    'apimessage' => 'Anda Terdeteksi Menggunakan Device Yang Berbeda!!'
                ]),200);
            }
        }
    }
    public function getUserByID($nip){
        $cek_data = User::where('nip','=',$nip)->join('jabatan','users.jabatan_id','=','jabatan.jabatan_id')->first();

        if ($cek_data) {
            $data = User::where('nip','=',$nip)->join('jabatan','users.jabatan_id','=','jabatan.jabatan_id')->first();
            $data['status'] = "success";
            $data['apimessage'] = "Data Diterima";
            return response()->json(array($data),200);
        }else{
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => 'Gagal Data Tidak Ada'
            ]),200);
        }
    }
    public function updateUser(Request $request)
    {
        if (empty($request->password)) {
            $data=array(
                'nama_user' => $request->nama_user,
                'alamat' => $request->alamat,
                'no_hp'=>$request->no_hp,
                'updated_at' => date('Y-m-d H:i:s')
            );
            User::where('nip','=',$request->nip)->update($data);
            return response()->json(array([
                'status' => 'success',
                'apimessage' => 'Data Diri Berhasil Diubah!!'
            ]),200);
        }else{
            $data=array(
                'nama_user' => $request->nama_user,
                'password'=> bcrypt($request->password),
                'alamat' => $request->alamat,
                'no_hp'=>$request->no_hp,
                'updated_at' => date('Y-m-d H:i:s')
            );
            User::where('nip','=',$request->nip)->update($data);
            return response()->json(array([
                'status' => 'success',
                'apimessage' => 'Data Password Berhasil Diubah!!'
            ]),200);
        }
    }
    public function changeFoto(Request $request)
    {
        if (!empty($request->foto_user)) {
            $foto_lama = User::where('nip','=',$request->nip)->first();

            if(\File::exists(public_path('foto/'.$foto_lama->foto_user))){
                \File::delete(public_path('foto/'.$foto_lama->foto_user));
            }else{
                return response()->json(array([
                    'status' => 'failed',
                    'apimessage' => 'File does not exists.'
                ]),200);
            }

            $namafoto = "Foto User"."  ".$request->nip." ".date("Y-m-d H-i-s");
            $extention = $request->file('foto_user')->extension();
            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/foto';
            $request->file('foto_user')->move($destination,$photo);

            $data['foto_user'] = $photo;
            User::where('nip','=',$request->nip)->update($data);
            return response()->json(array([
                'status' => 'success',
                'apimessage' => 'Foto Berhasil Diubah!'
            ]),200);
        }else{
            return response()->json(array([
                'status' => 'failed',
                'apimessage' => 'Gagal Mengubah Foto, Pilih Foto!!'
            ]),200);
        }
    }
}
