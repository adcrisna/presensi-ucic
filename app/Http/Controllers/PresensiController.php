<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Izin;
use App\Models\Presensi;
use Illuminate\Support\Facades\Storage;
use Fpdf;

class PresensiController extends Controller
{
    public function dataPresensi(){
        $data['title'] = "Data Presensi";
        $data['nama'] = Auth::user()->nama_user;
		$skrang = date('Y-m-d');
        $data['presensi'] = Presensi::join('users','presensi.nip','=','users.nip')
		->whereDate('jam_presensi',$skrang)->orderByRaw('presensi_id DESC')->get();
        return view('Admin/data_presensi',$data);
    }

    public function deleteDataPresensi(Request $request)
    {
        $data = Presensi::where('presensi_id','=',$request->presensi_id);
		$query = $data->first();
			if(\File::exists(public_path('foto/'.$query->foto_presensi))){
				\File::delete(public_path('foto/'.$query->foto_presensi));
			}else{
				\Session::flash('msg_gagal_hapus','Foto Presensi Gagal Dihapus!');
			return \Redirect::back();
			}
			$data->delete();
	        \Session::flash('msg_hapus_data','Data Presensi Berhasil Dihapus!');
			return \Redirect::back();
    }

    public function printDataPresensi(Request $request)
    {
		$pdf = new fPdf('P','mm');
		$pdf::SetAutoPageBreak(true);
		$pdf::SetTitle("Laporan Data Presensi Karyawan UCIC");
		$pdf::addPage('l','A4');
		$pdf::image( asset('cic.png'), $pdf::getX()+6, 8, 40 , 22,'PNG');
		$pdf::setX(80);
		$pdf::SetFont('Helvetica','B','13');
		$pdf::cell(135,6,"Laporan Data Presensi Karyawan",0,2,'C');
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

		$pdf::SetFont('Helvetica','','11');
		$pdf::ln();
		$pdf::cell(65,6,'',0,0,'');
		$pdf::cell(37,6,'',0,0,'');
		$pdf::cell(40,6,"Laporan Tanggal : ".$dari." - ".$sampai,0,0,'');
		$pdf::cell(40,6,'',0,0,'');
		$pdf::ln();
		$pdf::ln();
		$pdf::SetFont('Helvetica','B','11');
		$pdf::cell(40,6,'Nomor Induk',1,0,'C');
		$pdf::cell(65,6,'Nama',1,0,'C');
		$pdf::cell(45,6,'Email',1,0,'C');
		$pdf::cell(45,6,'Jabatan',1,0,'C');
		$pdf::cell(40,6,'Jumlah Presensi',1,0,'C');
		$pdf::cell(40,6,'Jumlah Izin',1,0,'C');
		$pdf::SetFont('Helvetica','','11');
		$pdf::ln();

			$nama = Auth::User()->nama_user;

			$presensi = User::join('presensi','users.nip','=','presensi.nip')
			->join('jabatan','jabatan.jabatan_id','=','users.jabatan_id')
			->selectRaw('users.nip, email, nama_jabatan, nama_user, count(presensi.nip) as jumlah_presensi')
			->whereBetween('jam_presensi',[$dari,$sampai])
			->groupBy('users.nip')
			->get();

			foreach ($presensi as $key => $value) {
				$pdf::cell(40,6,$value->nip,1,0,'C');
				$pdf::cell(65,6,$value->nama_user,1,0,'C');
				$pdf::cell(45,6,$value->email,1,0,'C');
				$pdf::cell(45,6,$value->nama_jabatan,1,0,'C');
				$pdf::cell(40,6,$value->jumlah_presensi/2,1,0,'C');

					$na[] = $value->nip;
					for ($i=0; $i <count($na) ; $i++) {
						$izin = Izin::where('izin.nip','=',$na[$i])
						->join('users','izin.nip','=','users.nip')
						->where('approved','=',"Disetujui")
						->selectRaw('count(izin.nip) as jumlah_izin')
						->whereBetween('tanggal_awal',[$dari,$sampai])
						->groupBy('users.nip')
						->get();
					}
					foreach ($izin as $key => $value) {
						$pdf::cell(40,6,$value->jumlah_izin,1,0,'C');
					}
						$pdf::ln();
			}
			$pdf::ln();
			$pdf::SetFont('Helvetica','B','11');
			$pdf::cell(65,6,'Detail Izin',0,0,'');
			$pdf::cell(47,6,'',0,0,'');
			$pdf::cell(40,6,"",0,0,'');
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
			$pdf::cell(45,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(80,6,'',0,0,'');
			$pdf::cell(40,6,"Cirebon, ".date('d-M-Y'),0,0,'');
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::cell(48,6,'',0,0,'');
			$pdf::cell(80,6,'',0,0,'');
			$pdf::cell(40,6,'Mengetahui,',0,0,'');
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::cell(43,6,'',0,0,'');
			$pdf::cell(80,6,'',0,0,'');
			$pdf::cell(40,6,$nama,0,0,'');
		$pdf::Output(0);
		exit;
    }
}
?>