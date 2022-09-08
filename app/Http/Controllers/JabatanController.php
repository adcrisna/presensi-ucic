<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function dataJabatan()
    {
        $data['title'] = "Data Jabatan";
        $data['nama'] = Auth::user()->nama_user;
        $data['jabatan'] = Jabatan::get();
        return view('Admin/jabatan',$data);
    }
    public function tambahDataJabatan(Request $request)
		{
			$data=array(
				'nama_jabatan'=>$request->namaJabatan,
			);
			Jabatan::insert($data);
			\Session::flash('msg_simpan_data','Data Jabatan Berhasil Ditambah!');
			return \Redirect::back();
		}
		public function deleteDataJabatan(Request $request)
		{
			$data = Jabatan::where('jabatan_id','=',$request->jabatan_id);
			$query = $data->first();
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Jabatan Berhasil Dihapus!');
				return \Redirect::back();
		}
		public function updateDataJabatan(Request $request)
		{
			$data=array(
				'nama_jabatan'=>$request->namaJabatan,
			);
			Jabatan::where('jabatan_id','=',$request->idJabatan)->update($data);
			\Session::flash('msg_update_data','Data Jabatan Berhasil Diupdate!');
			return Redirect::back();
		}
}
