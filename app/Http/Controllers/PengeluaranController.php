<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;

use App\Models\Pengeluaran;
use App\Models\MTransaksi;
use App\Models\GrandSaldo;
use App\Models\SaldoBOS;
use App\Models\SaldoSaving;
use App\Models\SaldoSPP;
use App\Models\SaldoEkskul;
use App\Models\Pemasukan;
use App\Models\MTranSiswa;


class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
        $data['title'] = "Pengeluaran";
        $data['pengeluaran'] = Pengeluaran::get();
        $data['transaksi'] = MTransaksi::where('jenis', '=', 'pengeluaran')->get();
        $data['pemasukan'] = Pemasukan::where('jumlah', '!=', '0')->get();
        $data['kegiatanSiswa'] = MTranSiswa::where('saldo', '!=', '0')->get();
        return view('transaksi.pengeluaran.main')->with($data);
    }

    public function post(Request $request)
    {   
        $grand = GrandSaldo::orderBy('id', 'desc')->first();
       
        if ($grand) {
            $id_transaksi = $request->id_transaksi;
            $transaksi = MTransaksi::where('id', $id_transaksi)->first();
            $file = $request->bukti;
            $fileName = time() . $transaksi->nama . $file->getClientOriginalName();
            $destination = 'uploads/pengeluaran';

            $absoluteDestination = public_path($destination);
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
            }
            
            $currentMonthName = date('F');
            $currentYear = date('Y');

            $sumber = $request->sumberInput;
            if ($sumber == "SPP") {
                $spp = SaldoSPP::orderBy('id', 'desc')->first();
                $saldo = $spp->saldo;
                $sumberPengeluaran = "SPP";
                if ($saldo >= $request->jumlah) {
                    $newSaldoSpp = SaldoSPP::create([
                        'keluar_masuk' => 'K',
                        'jumlah_km' => $request->jumlah,
                        'desc' => 'Pembayaran ' . $transaksi->name . '-' . $request->desc,
                        'saldo' => $saldo - $request->jumlah,
                        'user' => Auth::user()->id,
                        'bulan' => $currentMonthName,
                        'tahun' => $currentYear,
                       ]);
                }
               

            }elseif ($sumber == "BOS") {
                $bos = SaldoBOS::orderBy('id', 'desc')->first();
                $saldo = $bos->saldo;
                $sumberPengeluaran = "BOS";
                if ($saldo >= $request->jumlah) {
                    $newSaldoBos = SaldoBOS::create([
                        'keluar_masuk' => 'K',
                        'jumlah_km' => $request->jumlah,
                        'desc' => 'Pembayaran ' . $transaksi->name . '-' . $request->desc,
                        'saldo' => $saldo - $request->jumlah,
                        'user' => Auth::user()->id,
                        'bulan' => $currentMonthName,
                        'tahun' => $currentYear,
                       ]);
                }
               

            }elseif ($sumber == "Ekskul") {
                $ekskul = SaldoEkskul::orderBy('id', 'desc')->first();
                $saldo = $ekskul->saldo;
                $sumberPengeluaran = "Ekskul";
                if ($saldo >= $request->jumlah) {
                    $newSaldoEkskul = SaldoEkskul::create([
                        'keluar_masuk' => 'K',
                        'jumlah_km' => $request->jumlah,
                        'desc' => 'Pembayaran ' . $transaksi->name . '-' . $request->desc,
                        'saldo' => $saldo - $request->jumlah,
                        'user' => Auth::user()->id,
                        'bulan' => $currentMonthName,
                        'tahun' => $currentYear,
                       ]);    
                }
               
            }elseif ($sumber == "Saving") {
                $saving = SaldoSaving::orderBy('id', 'desc')->first();
                $saldo = $saving->saldo;
                $sumber = "Saving";
                if ($saldo >= $request->jumlah) {
                    $newSaldoSaving = SaldoSaving::create([
                        'keluar_masuk' => 'K',
                        'jumlah_km' => $request->jumlah,
                        'desc' => 'Pembayaran ' . $transaksi->name . '-' . $request->desc,
                        'saldo' => $saldo - $request->jumlah,
                        'user' => Auth::user()->id,
                        'bulan' => $currentMonthName,
                        'tahun' => $currentYear,
                    ]);
                }
               

            }elseif ($sumber == "KegiatanSiswa") {
                $tranSiswa = MTranSiswa::where('id', $request->idKegiatan)->first();
                $saldo = $tranSiswa->saldo;
                $sumber = "Kegiatan Siswa " . $tranSiswa->name;
                if ($saldo >= $request->jumlah) {
                    $tranSiswa->update([
                        'saldo' => $saldo - $request->jumlah,
                       ]);
                }
                
            }else {
                $pemasukan = Pemasukan::where('id', $request->idPemasukan)->first();
                $saldo = $pemasukan->jumlah;
                $sumber = "Pemasukan " . $pemasukan->transaksi . '-' . $pemasukan->desc;
                if ($saldo >= $request->jumlah) {
                    $pemasukan->update([
                        'jumlah' => $saldo - $request->jumlah,
                       ]);
                }
                
            }

            // var_dump($saldo);
            // die;
            if ($saldo >= $request->jumlah) {
                    $pengeluaran = Pengeluaran::create([
                        'id_transaksi'=>$request->id_transaksi,
                        'transaksi'=>$transaksi->nama,
                        'jumlah'=>$request->jumlah,
                        'sumber' => $sumber,
                        'bukti'=>$fileName,
                        'tanggal'=>$request->tanggal,
                        'desc'=>$request->desc,
                    ]);

                $lastSaldo = $grand->saldo;
                $saldo = $lastSaldo - $request->jumlah;
                // var_dump($saldo);
                // die();
                $newSaldo = GrandSaldo::create([
                    'saldo' => $saldo
                ]);
                $file->move($absoluteDestination, $fileName);
                return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$grand]);
            }else {
                return response()->json(['success' => false ,'message' => 'Dana Kurang, Pilih Opsi Lain!']);
            }
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::where('id', $id)->first();
        if ($pengeluaran) {
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'data' =>$pengeluaran]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function update(Request $request)
    {   
        $id = $request->id;
        $DataPengeluaran = Pengeluaran::where('id', $id)->first();
        if ($DataPengeluaran) {
            $grand = GrandSaldo::orderBy('id', 'desc')->first();

            if ($grand) {
                $id_transaksi = $request->id_transaksi;
                $transaksi = MTransaksi::where('id', $id_transaksi)->first();
                $file = $request->bukti;
                if ($file !== null && is_a($file, 'Illuminate\Http\UploadedFile') && $file->isValid()) {
                    $fileName = time() . $transaksi->nama . $file->getClientOriginalName();
                    $destination = 'uploads/pengeluaran';
                
                    $absoluteDestination = public_path($destination);
                    if (!Storage::exists($destination)) {
                        Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
                    }

                    $kalkulasi = $DataPengeluaran->jumlah;
                    $jumlah = $request->jumlah;
                    if ($kalkulasi > $jumlah) {
                        $newJumlah = $kalkulasi - $jumlah;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo + $newJumlah; 
                    }elseif ($kalkulasi < $jumlah) {
                        $newJumlah = $jumlah - $kalkulasi;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo - $newJumlah; 
                    }else {
                        $saldo = $grand->saldo;
                    }


                    $newSaldo = GrandSaldo::create([
                        'saldo' => $saldo
                    ]);

                    $DataPengeluaran->update([
                            'id_transaksi'=>$request->id_transaksi,
                            'transaksi'=>$transaksi->nama,
                            'jumlah'=>$request->jumlah,
                            'bukti'=>$fileName,
                            'tanggal'=>$request->tanggal,
                            'desc'=>$request->desc,
                    ]);
                   
                    $file->move($absoluteDestination, $fileName);
                    return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$grand]);
                }else {
                    $kalkulasi = $DataPengeluaran->jumlah;
                    $jumlah = $request->jumlah;
                    if ($kalkulasi > $jumlah) {
                        $newJumlah = $kalkulasi - $jumlah;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo + $newJumlah; 
                    }elseif ($kalkulasi < $jumlah) {
                        $newJumlah = $jumlah - $kalkulasi;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo - $newJumlah; 
                    }else {
                        $saldo = $grand->saldo;
                    }


                    $newSaldo = GrandSaldo::create([
                        'saldo' => $saldo
                    ]);

                    $DataPengeluaran->update([
                            'id_transaksi'=>$request->id_transaksi,
                            'transaksi'=>$transaksi->nama,
                            'jumlah'=>$request->jumlah,
                            'tanggal'=>$request->tanggal,
                            'desc'=>$request->desc,
                    ]);                   
                    return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$grand]);
                }
               
            }else {
                return response()->json(['success' => false ,'message' => 'Something Wrong!']);
            }
        }
    }

    public function deleted($id)
    {
        $pengeluaran = Pengeluaran::where('id', $id)->first();
        if ($pengeluaran) {
            $grand = GrandSaldo::orderBy('id', 'desc')->first();
            $PSaldo = $pengeluaran->jumlah;
            $saldo = $grand->saldo + $PSaldo;
            $grand = GrandSaldo::create([
                'saldo' => $saldo
            ]);

            $pengeluaran->delete();
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$grand]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }
}
