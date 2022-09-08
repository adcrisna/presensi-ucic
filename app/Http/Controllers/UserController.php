<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function dataKaryawan()
    {
        $data['title'] = "Data Karyawan";
        $data['nama'] = Auth::user()->nama_user;
        $data['karyawan'] = User::where('users.jabatan_id','!=',1)->join('jabatan','jabatan.jabatan_id','=','users.jabatan_id')->get();
        $data['jabatan'] = Jabatan::get();
        return view('Admin/karyawan_data',$data);
    }

    public function tambahDataKaryawan(Request $request)
    {
            $namafoto = "Foto User"."  ".$request->nip." ".date("Y-m-d H-i-s");
            $extention = $request->file('fotoUser')->extension();
            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/foto';
            $request->file('fotoUser')->move($destination,$photo);

        $na = DB::table('users')->where('nip','=',$request->nip)->first();
        if (!$na) {
        $user = User::create([
                'nip'=> $request->nip,
                'nama_user' => $request->namaUser,
                'email'=> $request->email,
                'no_hp' => $request->no_hp,
                'password'=> bcrypt($request->password),
                'serial_device' => "",
                'alamat' => $request->alamat,
                'jabatan_id'=>$request->id_jabatan,
                'foto_user' =>$photo,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
             \Session::flash('msg_simpan_data','Karyawan Berhasil Ditambah!');
            return \Redirect::back();
        }else{
            \Session::flash('msg_gagal','Nomor Induk Pegawai sudah terdaftar!!');
            return \Redirect::back();
        }
    }
    public function updateDataKaryawan(Request $request)
    {
        if (empty($request->foto_baru)) {
           if (empty($request->password)) {
                $data=array(
                    'nip'=> $request->nip,
                    'nama_user' => $request->namaUser,
                    'email'=> $request->email,
                    'no_hp' => $request->no_hp,
                    'serial_device' => $request->serial_device,
                    'alamat' => $request->alamat,
                    'jabatan_id'=>$request->id_jabatan,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_data','Data Karyawan Berhasil di Update!');
                return Redirect::route('data_karyawan');
           }else{
                $data=array(
                    'nip'=> $request->nip,
                    'nama_user' => $request->namaUser,
                    'email'=> $request->email,
                    'no_hp' => $request->no_hp,
                    'password'=> bcrypt($request->password),
                    'serial_device' => $request->serial_device,
                    'alamat' => $request->alamat,
                    'jabatan_id'=>$request->id_jabatan,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_data','Data Karyawan Berhasil di Update!');
                return Redirect::route('data_karyawan');
           }
        }else{
            if (empty($request->password)) {
                $data=array(
                    'nip'=> $request->nip,
                    'nama_user' => $request->namaUser,
                    'email'=> $request->email,
                    'no_hp' => $request->no_hp,
                    'serial_device' => $request->serial_device,
                    'alamat' => $request->alamat,
                    'jabatan_id'=>$request->id_jabatan,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                if ($request->file('foto_baru')) 
                    {
                        if(\File::exists(public_path('foto/'.$request->foto_lama))){
                            \File::delete(public_path('foto/'.$request->foto_lama));
                        }else{
                            \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                            return Redirect::route('data_karyawan');
                        }

                        $namafoto = "Foto User"."  ".$request->nip." ".date("Y-m-d H-i-s");
                        $extention = $request->file('foto_baru')->extension();
                        $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                        $destination = base_path() .'/public/foto';
                        $request->file('foto_baru')->move($destination,$photo);
                        $data['foto_user'] = $photo;
                    }
                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_data','Data Karyawan Berhasil di Update!');
                return Redirect::route('data_karyawan');
           }else{
                $data=array(
                    'nip'=> $request->nip,
                    'nama_user' => $request->namaUser,
                    'email'=> $request->email,
                    'no_hp' => $request->no_hp,
                    'password'=> bcrypt($request->password),
                    'serial_device' => $request->serial_device,
                    'alamat' => $request->alamat,
                    'jabatan_id'=>$request->id_jabatan,
                    'updated_at' => date('Y-m-d H:i:s')
                );
                if ($request->file('foto_baru')) 
                {
                    if(\File::exists(public_path('foto/'.$request->foto_lama))){
                        \File::delete(public_path('foto/'.$request->foto_lama));
                    }else{
                        \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                        return Redirect::route('data_karyawan');
                    }

                    $namafoto = "Foto User"."  ".$request->nip." ".date("Y-m-d H-i-s");
                    $extention = $request->file('foto_baru')->extension();
                    $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                    $destination = base_path() .'/public/foto';
                    $request->file('foto_baru')->move($destination,$photo);
                    $data['foto_user'] = $photo;
                }

                User::where('id','=',$request->id)->update($data);
                \Session::flash('msg_update_data','Data Karyawan Berhasil di Update!');
                return Redirect::route('data_karyawan');
           }
        }
    }

    public function deleteDataKaryawan(Request $request)
    {
        $data = User::where('id','=',$request->id);
			$query = $data->first();
			if(\File::exists(public_path('foto/'.$query->foto_user))){
				\File::delete(public_path('foto/'.$query->foto_user));
			}else{
			    \Session::flash('msg_gagal_foto','Gagal Update Foto!');
                 return Redirect::route('data_karyawan');
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Karyawan Berhasil Dihapus!');
			return \Redirect::back();
    }
}
?>