<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


use App\Models\MTransaksi;
use App\Models\MTranSiswa;
use App\Models\MKelas;
use App\Models\MSiswa;
use App\Models\TransaksiSiswa;
use App\Models\GrandSaldo as Saldo;
use App\Models\BuktiTransaksiSiswa as Bukti;
use App\Models\Kwitansi;
 

class TransisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($id = null)
    {
        $transaksi = MTranSiswa::where('id', $id)->first();
        
        if ($transaksi == null) {
            $data['title'] = 'Transaksi ';
            $data['siswa_id'] = TransaksiSiswa::orderBy('kelas', 'asc')->orderBy('nis', 'asc')->get();
            
            $data['transId'] = "Pilih Transaksi Dahulu Dahulu";
            $data['klz'] = MKelas::get();
        }else {
            $data['title'] = 'Transaksi '. $transaksi->name;
            $data['selectId'] = MTranSiswa::orderBy('id', 'asc')->get();
            $siswaInTrans = json_decode($transaksi->siswa_id);
            $kelasInTrans = json_decode($transaksi->kelas_id);
            
            $data['siswa_id'] = TransaksiSiswa::where('trans_id', $id)->orderBy('kelas', 'asc')->orderBy('nis', 'asc')->get();
            
            $data['klz'] = MKelas::whereIn('id', $kelasInTrans)->get();
            $data['transId'] = $transaksi;

        }

        $data['selectId'] = MTranSiswa::get();
        
       

        return view('transaksi.siswa.main', compact('transaksi'))->with($data);
    }

    public function pay(Request $request)
    {
        $transId = $request->transId;
        $transaksi = MTranSiswa::where('id', $transId)->first();
        $harga = $transaksi->jumlah;
        $siswaId = $request->id;
        $siswa = MSiswa::where('id', $siswaId)->first();
        if ($siswa) {
            $transaksiSiswa = TransaksiSiswa::where('trans_id', $transId)->where('siswa_id', $siswaId)->first();

            if ($transaksiSiswa) {
                $sudahBayar = $transaksiSiswa->jumlah;
                $bayarNow = $request->jumlah;
                $total = $sudahBayar + $bayarNow;
                $kurangBayar = $transaksiSiswa->kurang - $total; 
                if ($harga == $total) {
                    $lunas = "Y";
                    $lunas_at = Carbon::now();
                    $paid_at = $request->paid_at;

                }elseif ($harga >= $total) {
                    $lunas = "N";
                    $lunas_at = null;
                    $paid_at = $request->paid_at;

                }else {
                    return response()->json(['success' => false ,'message' => 'Jumlah Pembayaran Melebihi Harga!!','data'=> $transaksiSiswa]);

                }
                $transaksiSiswa->update([
                    'jumlah'=>$total,
                    'lunas'=>$lunas,
                    'kurang' => $kurangBayar,
                    'paid_at'=>$paid_at,
                    'lunas_at'=>$lunas_at,
                ]);

                $kwitansi = Kwitansi::create([
                    'trans_id'=>$transaksiSiswa->id,
                    'siswa_id'=>$siswa->id,
                    'transaksi'=>$transaksiSiswa->trans_name,
                    'siswa_name'=>$siswa->name,
                    'nis'=>$siswa->nis,
                    'kelas'=>$siswa->kelas,
                    'jumlah'=>$request->jumlah,
                    'lunas'=>$lunas,
                    'paid_at'=>$request->paid_at,
                ]);

                $gs = Saldo::orderBy('id', 'desc')->first();
                $oldSaldo = $gs->saldo;
                $newSaldo = $oldSaldo + $bayarNow;
                $newGS = Saldo::create([
                    'saldo'=>$newSaldo
                ]);

                $file = $request->bukti;
                $fileName = time() . $file->getClientOriginalName();
                $destination = 'uploads/transaksiSiswa';
     
                $absoluteDestination = public_path($destination);
                if (!Storage::exists($destination)) {
                    Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
                }
                $bukti = Bukti::create([
                    'trans_id'=>$transaksiSiswa->id,
                    'bukti'=>$fileName,
                    'paid_at'=>$paid_at,
                ]);
                $file->move($absoluteDestination, $fileName);

                return response()->json(['success' => true ,'message' => 'Pembayran Sukses!!','data'=> $transaksiSiswa]);

            }else {
                return response()->json(['success' => false ,'message' => 'Data Tidak Ditemukan!!']);

            }

            return response()->json(['success' => true ,'message' => 'Pembayran Sukses!!','data'=> $newTransaksi]);

        }else {
            return response()->json(['success' => false ,'message' => 'Data Tidak Ditemukan!!']);

        }
    }

    public function Bukti($transis, $id)
    {
        $transaksi = TransaksiSiswa::where('trans_id', $transis)->where('siswa_id', $id)->first();
        if ($transaksi) {
            return response()->json(['success' => true ,'message' => 'Sukses!!','data'=> $transaksi]);
        }else {
            return response()->json(['success' => false ,'message' => 'Pembayaran Belum Ada!!']);
        }
    }

    public function Print($id)
    {
        $bukti = Bukti::where('trans_id', $id)->get();
        $transaksi = TransaksiSiswa::where('id', $id)->first();

        return view('print.transaksi_siswa', compact('bukti', 'transaksi'));
    }

    public function reportPrint($kelas, $trans_id)
    {
        $transaksi = TransaksiSiswa::where('trans_id', $trans_id)->get();
        $transaksiMaster = MTranSiswa::where('id', $trans_id)->first();
        $duit = $transaksi ? $transaksi->sum('jumlah') : 0;

        $id_siswa = json_decode($transaksiMaster->siswa_id);
        $kelasArray = explode(',', $kelas);
        $data['klls'] = MKelas::whereIn('id', $kelasArray)->get();
        $klz = $kelas;
        
        // dd($kelasArray);
        $siswa = TransaksiSiswa::where('trans_id', $trans_id)->whereIn('kelas_id', $kelasArray)->orderBy('kelas', 'asc')->orderBy('grade', 'asc')->orderBy('nis', 'asc')->get();

        return view('print.transaksiSiswa.report', compact('transaksi', 'siswa', 'duit', 'klz', 'transaksiMaster'))->with($data);
    }

    public function Tagihan($id, $transis)
    {
        $siswa = MSiswa::where('id', $id)->first();
        $mtrans = MTranSiswa::where('id', $transis)->first();
        $harga = $mtrans->jumlah;
        // var_dump($mtrans);
        // die();

        $transaksi = TransaksiSiswa::where('trans_id', $transis)->where('siswa_id', $id)->first();
        if ($transaksi) {
            $jumlah = $transaksi->jumlah;

            if ($jumlah == $harga) {
                return response()->json(['success' => false ,'message' => 'Pembayaran Sudah Lunas!!']);
            }elseif ($jumlah <= $harga) {
                $kurang = $harga - $jumlah;
                return response()->json(['success' => true ,'message' => 'Tunggu Sebentar Ya!!', 'data'=>$kurang, 'siswa'=>$siswa, 'master'=>$mtrans]);

            }else {
                return response()->json(['success' => false ,'message' => 'Pembayaran Sudah Lunas!!']);

            }
        }else {

            $kurang = $harga;
            return response()->json(['success' => true ,'message' => 'Tunggu Sebentar Ya!!', 'data'=>$kurang, 'siswa'=>$siswa, 'master'=>$mtrans]);

        }
    }

    public function TagihanPrint($id, $kurang, $master)
    {
        $data['siswa'] = MSiswa::where('id', $id)->first();
        $data['kurang']= $kurang;
        $data['terbilang'] = $this->terbilang($data['kurang']);
        $data['transaksi'] = MTranSiswa::where('id', $master)->first();

        return view('print.transaksiSiswa.tagihan')->with($data);
    }

    private function terbilang($number)
    {
        $x = abs($number);
        $angka = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

        $result = "";
        if ($x < 12) {
            $result = " " . $angka[$x];
        } elseif ($x < 20) {
            $result = $this->terbilang($x - 10) . " Belas";
        } elseif ($x < 100) {
            $result = $this->terbilang($x / 10) . " Puluh" . $this->terbilang($x % 10);
        } elseif ($x < 200) {
            $result = " Seratus" . $this->terbilang($x - 100);
        } elseif ($x < 1000) {
            $result = $this->terbilang($x / 100) . " Ratus" . $this->terbilang($x % 100);
        } elseif ($x < 2000) {
            $result = " Seribu" . $this->terbilang($x - 1000);
        } elseif ($x < 1000000) {
            $result = $this->terbilang($x / 1000) . " Ribu" . $this->terbilang($x % 1000);
        } elseif ($x < 1000000000) {
            $result = $this->terbilang($x / 1000000) . " Juta" . $this->terbilang($x % 1000000);
        } elseif ($x < 1000000000000) {
            $result = $this->terbilang($x / 1000000000) . " Milyar" . $this->terbilang(fmod($x, 1000000000));
        } elseif ($x < 1000000000000000) {
            $result = $this->terbilang($x / 1000000000000) . " Trilyun" . $this->terbilang(fmod($x, 1000000000000));
        }

        return $result;
    }
   

}
