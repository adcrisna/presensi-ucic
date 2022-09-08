<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Models\User;
use App\Models\Absensi;

class KaryawanController extends Controller
{
    public function index(){
        $data['title'] = "Home";
        $data['nama'] = Auth::user()->nama_user;
        return view('Karyawan/home_karyawan',$data);
    }

    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }

    public function historyPresensiKaryawan()
    {
        $data['title'] = "History Presensi";
        $data['nama'] = Auth::user()->nama_user;
        $nip_karyawan = Auth::user()->nip;
        $data['presensi'] = Absensi::where('nip','=',$nip_karyawan)->get();
        return view('Karyawan/presensi_karyawan',$data);
    }

    public function profileKaryawan()
    {
        $data['title'] = "Profile";
        $data['nama'] = Auth::user()->nama_user;
        $id_karyawan = Auth::user()->id;
        $data['karyawan'] = User::where('id','=',$id_karyawan)
        ->join('jabatan','jabatan.jabatan_id','=','users.jabatan_id')->first();
        return view('Karyawan/profile_karyawan',$data);
    }

    public function updateProfileKaryawan(Request $request)
    {
        if (empty($request->foto_baru)) {
           if (empty($request->password)) {
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'alamat'=>$request->alamat,
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_karyawan');
           }else{
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_karyawan');
           }
        }else{
            if (empty($request->password)) {
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'alamat'=>$request->alamat,
                );
                if ($request->file('foto_baru')) 
                    {
                        if(\File::exists(public_path('foto/'.$request->foto_lama))){
                            \File::delete(public_path('foto/'.$request->foto_lama));
                        }else{
                            \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                            return Redirect::route('profile_karyawan');
                        }

                        $photo = $request->file('foto_baru')->getClientOriginalName();
                        $destination = base_path() .'/public/foto';
                        $request->file('foto_baru')->move($destination,$photo);
                        $data['foto_user'] = $photo;
                    }
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_karyawan');
           }else{
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                );
                if ($request->file('foto_baru')) 
                {
                    if(\File::exists(public_path('foto/'.$request->foto_lama))){
                        \File::delete(public_path('foto/'.$request->foto_lama));
                    }else{
                        \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                        return Redirect::route('profile_karyawan');
                    }

                    $photo = $request->file('foto_baru')->getClientOriginalName();
                    $destination = base_path() .'/public/foto';
                    $request->file('foto_baru')->move($destination,$photo);
                    $data['foto_user'] = $photo;
                }

                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_karyawan');
           }
        }
    }
}
?>