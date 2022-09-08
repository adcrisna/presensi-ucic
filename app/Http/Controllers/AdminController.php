<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Jabatan;
use Redirect;

class AdminController extends Controller
{
    public function index(){
        $data['title'] = "Home";
        $data['nama'] = Auth::user()->nama_user;
        return view('Admin/home_admin',$data);
    }

    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }

    public function profileAdmin()
    {
        $data['title'] = "Profile";
        $data['nama'] = Auth::user()->nama_user;
        $id = Auth::user()->id;
        $data['admin'] = User::where('id','=',$id)
        ->join('jabatan','jabatan.jabatan_id','=','users.jabatan_id')->first();
        return view('Admin/profile_admin',$data);
    }

    public function updateProfileAdmin(Request $request)
    {
        if (empty($request->foto_baru)) {
           if (empty($request->password)) {
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'no_hp'=>$request->no_hp,
                    'alamat'=>$request->alamat,
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_admin');
           }else{
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'no_hp'=>$request->no_hp,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_admin');
           }
        }else{
            if (empty($request->password)) {
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'no_hp'=>$request->no_hp,
                    'alamat'=>$request->alamat,
                );
                if ($request->file('foto_baru')) 
                    {
                        if(\File::exists(public_path('foto/'.$request->foto_lama))){
                            \File::delete(public_path('foto/'.$request->foto_lama));
                        }else{
                            \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                            return Redirect::route('profile_admin');
                        }

                        $namafoto = "Foto Bagian Kepegawaian"."  ".$request->nip." ".date("Y-m-d H-i-s");
                        $extention = $request->file('foto_baru')->extension();
                        $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                        $destination = base_path() .'/public/foto';
                        $request->file('foto_baru')->move($destination,$photo);
                        $data['foto_user'] = $photo;
                    }
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_admin');
           }else{
                $data=array(
                    'nama_user'=>$request->nama,
                    'email'=>$request->email,
                    'no_hp'=>$request->no_hp,
                    'password'=>bcrypt($request->password),
                    'alamat'=>$request->alamat,
                );
                if ($request->file('foto_baru')) 
                {
                    if(\File::exists(public_path('foto/'.$request->foto_lama))){
                        \File::delete(public_path('foto/'.$request->foto_lama));
                    }else{
                        \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                        return Redirect::route('profile_admin');
                    }

                    $namafoto = "Foto Bagian Kepegawaian"."  ".$request->nip." ".date("Y-m-d H-i-s");
                    $extention = $request->file('foto_baru')->extension();
                    $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                    $destination = base_path() .'/public/foto';
                    $request->file('foto_baru')->move($destination,$photo);
                    $data['foto_user'] = $photo;
                }

                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_profile','Data Profile Berhasil di Update!');
                return Redirect::route('profile_admin');
           }
        }
    }
}
?>