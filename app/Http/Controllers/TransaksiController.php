<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MTransaksi;
use App\Models\MTranSiswa;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\MSPP;
use App\Models\TransaksiSiswa;


class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function MainPengeluaran()
    {

        $data['title'] = 'Master Transaksi';
        $data['pengeluaran'] = MTransaksi::where('jenis', '=', 'pengeluaran')->get();
        return view('master.transaksi.pengeluaran')->with($data);
    }

    public function MainPemasukan()
    {

        $data['title'] = 'Master Transaksi';
        $data['pengeluaran'] = MTransaksi::where('jenis', '=', 'pemasukan')->get();
        return view('master.transaksi.pemasukan')->with($data);
    }

    public function Store(Request $request)
    {
            $transaksi = MTransaksi::create([
                'jenis' => $request->jenis,
                'nama' => $request->nama,
            ]);
    
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $transaksi,]);
    }

    public function Edit ($id)
    {
        $transaksi = MTransaksi::where('id', $id)->first();
        if ($transaksi) {
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $transaksi]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function Update(Request $request)
    {
        $id = $request->id;
        $transaksi = MTransaksi::where('id', $id)->first();
        if ($transaksi) {
           $transaksi->update([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
           ]);
           return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $transaksi]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function Delete($id)
    {
        $transaksi = MTransaksi::where('id', $id)->first();
        if ($transaksi) {
            $transaksi->delete();

            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function MainSiswa()
    {
        $data['title'] = "Transaksi Siswa";

        $data['transaksi'] = MTranSiswa::orderBy('created_at','desc')->orderBy('done', 'asc')->get();
        $data['kelas'] = MKelas::orderBy('kelas', 'asc')->get();
        return view('master.transaksi.siswa')->with($data);
    }

    public function StoreSiswa(Request $request)
    {
        $kelas = $request->kelas;
        // var_dump($kelas);
        // die();
        $siswa = MSiswa::whereIn('kelas_id', $kelas)->get();
        $siswa_id = $siswa->pluck('id')->toArray();
        // var_dump($siswa);
        // die();
        $kezel = MKelas::whereIn('id', $kelas)->get();
        $kelasId = $kezel->pluck('id')->toArray();
        $kelasGradeArray = []; // Inisialisasi a;rray untuk menyimpan nilai kelasGrade
        
        foreach ($kezel as $kzl) {
            $noKel = $kzl->kelas;
            $grade = $kzl->grade;
        
            // Menggabungkan kelas dan grade menjadi satu string dan menambahkannya ke dalam array
            $kelasGradeArray[] = $noKel . $grade;
        }
        
        // Mengonkatenasi semua nilai kelasGrade dari array
        $kelasGrade = json_encode($kelasGradeArray);

        // var_dump($kelasGrade);
        // die();
        $transaksi = MTranSiswa::create([
            'name'=>$request->name,
            'kelas_id'=>json_encode($kelasId),
            'kelas'=>$kelasGrade,
            'siswa_id' => json_encode($siswa_id),
            'jumlah'=>$request->jumlah,
            'done'=>'N',
            'created_at'=>$request->created_at,
        ]);
        // $id_trans = $transaksi->id;
        // var_dump($id_trans);
        // die();

        if ($transaksi) {
            foreach ($siswa as $sis) {
                $trans_siswa = TransaksiSiswa::create([
                    'trans_id'=>$transaksi->id,
                    'siswa_id'=>$sis->id,
                    'trans_name'=>$transaksi->name,
                    'siswa_name'=>$sis->name,
                    'nis'=>$sis->nis,
                    'kelas_id'=>$sis->kelas_id,
                    'kelas'=>$sis->kelas,
                    'grade'=>$sis->grade,
                    'jumlah'=> null,
                    'kurang'=>$request->jumlah,
                    'harus_bayar'=>$request->jumlah,
                    'lunas'=>"N",
                    'paid_at'=>null,
                    'lunas_at'=>null,
                ]);
            }
        }
        return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $transaksi]);

    }
    
    public function MainSPP()
    {
        $data['title'] = "Mater SPP";

        $data['klz'] = MKelas::get();
        $data['spp'] = MSPP::get();

        return view('master.transaksi.spp')->with($data);

    }
}
