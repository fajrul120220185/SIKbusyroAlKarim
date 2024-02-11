<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Mkelas;
use App\Models\Msiswa;
use App\Models\spp;
use App\Models\GrandSaldo;
use App\Models\Kwitansi;

class SPPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($kelas = null)
    {
        $mkelas = MKelas::where('id', $kelas)->first();
        $data['title'] = 'SPP Kelas ' . $mkelas->kelas . $mkelas->grade;

        $data['kelas'] = Mkelas::orderBy('kelas', 'asc')->get();
        $data['siswa'] = Msiswa::where('kelas_id', $mkelas->id)->where('yatim', '=', 'N')->orderBy('nis', 'asc')->get();
        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;
        // dd($data['siswa']);
        $klz = $kelas;
        if ($mkelas) {
            # code...
            $data['tarif'] = $mkelas->tarif_spp;
        }else {
            $data['tarif'] = '0';
        }
        return view('spp.main', compact('tahun', 'klz', 'bulan'))->with($data);
    }

    public function pay(Request $request)
    {
        $id  = $request->id;
        $siswa = MSiswa::where('id', $id)->first();
        $bulan = $request->bulan;
        // var_dump($bulan);
        // die();
        if ($siswa) {
            
            $kelas_id = $siswa->kelas_id;

            $bulan = $request->bulan;
            $tahun = $request->tahun;
           
           
                $file = $request->bukti;
                $fileName = time() . $siswa->name. $bulan. $tahun . $file->getClientOriginalName();
                $destination = 'uploads/spp';
    
                $absoluteDestination = public_path($destination);
                if (!Storage::exists($destination)) {
                    Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
                }
                $spp = SPP::where('siswa_id', $id)->where('bulan', $bulan)->where('tahun', $tahun)->first();
                if ($spp) {
                    if ($spp->lunas === 'N') {
                        $spp->update([
                            'jumlah' =>$request->jumlah,
                            'lunas'=>"Y",
                            'bukti' =>$fileName,
                            'paid_at' =>$request->paid_at,
                        ]);
                        $kwitansi = Kwitansi::create([
                            'trans_id'=>$spp->id,
                            'siswa_id'=>$siswa->id,
                            'transaksi'=>"SPP",
                            'siswa_name'=>$siswa->name,
                            'nis'=>$siswa->nis,
                            'kelas'=>$siswa->kelas,
                            'jumlah'=>$request->jumlah,
                            'lunas'=>"Y",
                            'paid_at'=>$request->paid_at,
                        ]);
            
                        $saldo  = GrandSaldo::orderBy('id', 'desc')->first();
                        $lastSaldo = $saldo->saldo;
                        $newSaldo = $lastSaldo + $request->jumlah;
                        $Grs = GrandSaldo::create([
                            'saldo'=>$newSaldo
                        ]);
            
                        $file->move($absoluteDestination, $fileName);
                        return response()->json(['success' => true ,'message' => 'updated successfully!', 'data' =>$spp, 'saldo'=>$Grs]);
                    }else {
                        return response()->json(['success' => false ,'message' => 'Sudah Pernah Bayar!']);
                    }
                }else {
                    return response()->json(['success' => false ,'message' => 'Data Tidak Ditemukan!']);
                }
                
            
            
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function reportPrint($kelas, $tahun, $bulan)
    {
        $data['klz'] = $kelas;
        $data['bln'] = $bulan;
        $data['thn'] = $tahun;

        $data['kelasz'] = MKelas::where('id', $kelas)->first();

        $data['siswa'] = MSiswa::where('kelas_id', $kelas)->where('yatim', '=', 'N')->get();
        $data['spp'] = SPP::where('kelas_id', $kelas)->where('bulan', $tahun)->where('tahun', $bulan)->get();
        $spp = SPP::where('kelas_id', $kelas)->where('bulan', $tahun)->where('tahun', $bulan)->get();
        $duit = $spp->sum('jumlah');
        
        
        return view('print.spp.rep', compact('duit'))->with($data);
    }

    public function Bukti($id, $bulan, $tahun)
    {
        // var_dump($id, $bulan, $tahun);
        // die();
        $spp = SPP::where('siswa_id', $id)->where('bulan', $bulan)->where('tahun', $tahun)->first();
      
       
        if ($spp) {
            return response()->json(['success' => true ,'message' => 'Suksess!', 'data'=>$spp]);
        }else {
            return response()->json(['success' => false ,'message' => 'Belum Ada Pembayaran!']);

        }
    }

    public function Print($id)
    {
        $spp = SPP::where('id', $id)->first();
        
        return view('print.spp.bukti', compact('spp'));
    }

    public function Tagihan ($id, $bulan, $tahun)
    {
        
        $bulanArray = explode(',', $bulan);
        // var_dump($bulanArray);
        // die();
        $spp = SPP::where('siswa_id', $id)->where('bulan', $bulan)->where('tahun', $tahun)->get();
        //   var_dump($spp);
        // die();
       
        if ($spp) {
            return response()->json(['success' => false ,'message' => 'Sudah Pernah Bayar!', 'data'=>$spp]);
        }else {
            $siswa = MSiswa::where('id', $id)->first();
            $bulan = $bulan;
            $tahun = $tahun;
            return response()->json(['success' => true ,'message' => 'Tunggu Sebentar Ya!', 'data'=>$siswa, 'bulan'=>$bulan, 'tahun'=>$tahun]);

        }
    }

    public function PrintTagihan($id, $bulan, $tahun)
    {
        $data['siswa'] = MSiswa::where('id', $id)->first();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        
        return view('print.spp.tagihan')->with($data);
    }
}