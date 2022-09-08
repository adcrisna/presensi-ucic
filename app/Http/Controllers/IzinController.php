<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Izin;
use Illuminate\Support\Facades\Storage;
use Fpdf;

class IzinController extends Controller
{
    public function dataIzin(){
        $data['title'] = "Data Izin";
        $data['nama'] = Auth::user()->nama_user;
        $data['izin'] = Izin::join('users','izin.nip','=','users.nip')->orderByRaw('izin_id DESC')->get();
        return view('Admin/data_izin',$data);
    }
    public function deleteDataIzin(Request $request)
    {
        $data = Izin::where('izin_id','=',$request->izin_id);
		$query = $data->first();
			if(\File::exists(public_path('foto/'.$query->foto_bukti))){
				\File::delete(public_path('foto/'.$query->foto_bukti));
			}else{
				\Session::flash('msg_gagal_hapus','Foto Bukti Gagal Dihapus!');
			return \Redirect::back();
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Izin Berhasil Dihapus!');
			return \Redirect::back();
    }
    public function accDataIzin(Request $request)
    {
        $data=array(
            'approved'=> "Disetujui",
            'komentar'=> "Oke Disetujui"
        );

        Izin::where('izin_id','=',$request->izin_id)->update($data);
        \Session::flash('msg_update_data_izin','Izin berhasil disetujui!');
        return \Redirect::back();
    }
    public function tolakDataIzin(Request $request)
    {
        $data=array(
            'approved'=> "Ditolak",
            'komentar'=> $request->catatan
        );

        Izin::where('izin_id','=',$request->izin_id)->update($data);
        \Session::flash('msg_update_data_izin','Izin berhasil Ditolak!');
        return \Redirect::back();
    }

    public function printDataIzin(Request $request)
    {
		$pdf = new fPdf('P','mm');
		$pdf::SetAutoPageBreak(true);
		$pdf::SetTitle("Laporan Data Izin Karyawan UCIC");
		$pdf::addPage('L','A4');
		$pdf::image( asset('cic.png'), $pdf::getX()+10, 7, 42 , 22,'PNG');
		$pdf::setX(80);
		$pdf::SetFont('Helvetica','B','13');
		$pdf::cell(135,6,"Laporan Data Izin Karyawan",0,2,'C');
		$pdf::SetFont('Helvetica','B','13');
		$pdf::cell(135,6,"UNIVERSITAS CATUR INSAN CENDIKIA",0,2,'C');
		$pdf::SetFont('Helvetica','','10');
		$pdf::cell(135,6,"Jl. Kesambi No. 202, Drajat, Kec. Kesambi, Kota Cirebon, Jawa Barat, 45133",0,2,'C');
		$pdf::SetFont('Helvetica','B','12');
		$pdf::cell(135,6,"",0,2,'C');
		$pdf::line(10,($pdf::getY()+3),285,($pdf::getY()+3));
		$pdf::ln();
			$tgl_dari = $request->tgl_dari;
			$tgl_sampai = $request->tgl_sampai;
			$dari = date('Y-m-d',strtotime($tgl_dari));
			$sampai = date('Y-m-d',strtotime($tgl_sampai));
            $nama = Auth::user()->nama_user;

		$pdf::SetFont('Helvetica','','11');
		$pdf::ln();
		$pdf::cell(55,6,'',0,0,'');
		$pdf::cell(45,6,'',0,0,'');
		$pdf::cell(38,6,"Laporan Tanggal : ".$dari." - ".$sampai,0,0,'');
		$pdf::cell(40,6,'',0,0,'');
		$pdf::ln();
			$pdf::ln();
			$pdf::SetFont('Helvetica','B','11');
			$pdf::cell(45,6,'Nama',1,0,'C');
			$pdf::cell(35,6,'Status Izin',1,0,'C');
			$pdf::cell(80,6,'Keterangan Izin',1,0,'C');
            $pdf::cell(40,6,'Tanggal Izin',1,0,'C');
            $pdf::cell(40,6,'Tanggal Berakhir',1,0,'C');
			$pdf::cell(35,6,'Lama Izin',1,0,'C');
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();

				$iz = Izin::where('approved','=','Disetujui')
				->join('users','izin.nip','=','users.nip')
				->whereBetween('tanggal_awal',[$dari,$sampai])
				->get();
				foreach ($iz as $key => $value) {
					$pdf::cell(45,6,$value->nama_user,1,0,'C');
					$pdf::cell(35,6,$value->status_izin,1,0,'C');
					$pdf::cell(80,6,$value->keterangan_izin,1,0,'C');
                    $pdf::cell(40,6,$value->tanggal_awal,1,0,'C');
                    $pdf::cell(40,6,$value->tanggal_akhir,1,0,'C');
					$pdf::cell(35,6,$value->lama_izin." Hari",1,0,'C');
					$pdf::ln();
				}
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(55,6,'',0,0,'');
            $pdf::cell(75,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,"Cirebon, ".date('d-M-Y'),0,0,'');
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(55,6,'',0,0,'');
            $pdf::cell(75,6,'',0,0,'');
			$pdf::cell(48,6,'',0,0,'');
			$pdf::cell(40,6,'Mengetahui,',0,0,'');
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(55,6,'',0,0,'');
            $pdf::cell(75,6,'',0,0,'');
            $pdf::cell(43,6,'',0,0,'');
			$pdf::cell(40,6,$nama,0,0,'');
		$pdf::Output(0);
		exit;
    }
}
