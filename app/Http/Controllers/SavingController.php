<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Models\SaldoBOS;
use App\Models\SaldoSaving;
use App\Models\SaldoSPP;
use App\Models\SaldoEkskul;
use App\Models\Pemasukan;
use App\Models\MTranSiswa;

use App\Models\Saving;

class SavingController extends Controller
{
    public function index()
    {
        $data['title'] = 'Saving';

        $data['laporanSaving'] = Saving::orderBy('tgl_masuk', 'asc')->get();
        $saving = SaldoSaving::orderBy('id', 'desc')->first();
        $data['saldoSaving'] = $saving->saldo; 

        // Sumber
        $data['pemasukan'] = Pemasukan::where('jumlah', '!=', '0')->get();
        $data['kegiatanSiswa'] = MTranSiswa::where('saldo', '!=', '0')->get();
        return view('saving.main', $data);
    }

    public function store(Request $request)
    {
        $jumlah = $request->jumlah;
        $sumber = $request->sumberInput;
        $oldSaving = SaldoSaving::orderBy('id', 'desc')->first();
        $oldSaldoSaving = $oldSaving->saldo;

        $currentMonthName = date('F');
        $currentYear = date('Y');

        if ($sumber ==  'SPP') {
            $spp = SaldoSPP::orderBy('id', 'desc')->first();
            $saldoSPP = $spp->saldo;
            if ($saldoSPP >= $jumlah) {
               $saving = Saving::create([
                'jumlah' => $request->jumlah,
                'sumber' => "SPP",
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               $newSaldoSaving = SaldoSaving::create([
                'keluar_masuk' => 'M',
                'jumlah_km' => $request->jumlah,
                'desc' => 'Dari SPP',
                'saldo' => $oldSaldoSaving + $jumlah,
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               $newSaldoSpp = SaldoSPP::create([
                'keluar_masuk' => 'K',
                'jumlah_km' => $request->jumlah,
                'desc' => 'Pindah Ke Saving',
                'saldo' => $saldoSPP - $jumlah,
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               return redirect()->route('savingIndex')->with('success', 'Berhasil Pindah !!');
            }else {
                return redirect()->route('savingIndex')->with('error', 'Saldo Kurang, Pilih Transaksi Lain !!');
            }
        }elseif ($sumber == "BOS") {
            $bos = SaldoBOS::orderBy('id', 'desc')->first();
            $saldoBos = $bos->saldo;
           if ($saldoBos >= $jumlah) {
                $saving = Saving::create([
                'jumlah' => $request->jumlah,
                'sumber' => "BOS",
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               $newSaldoSaving = SaldoSaving::create([
                'keluar_masuk' => 'M',
                'jumlah_km' => $request->jumlah,
                'desc' => 'Dari BOS',
                'saldo' => $oldSaldoSaving + $jumlah,
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               $newSaldoBos = SaldoBOS::create([
                'keluar_masuk' => 'K',
                'jumlah_km' => $request->jumlah,
                'desc' => 'Pindah Ke Saving',
                'saldo' => $saldoBos - $jumlah,
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
               ]);
               return redirect()->route('savingIndex')->with('success', 'Berhasil Pindah !!');
           }else {
            return redirect()->route('savingIndex')->with('error', 'Saldo Kurang, Pilih Transaksi Lain !!');
            }
        }elseif ($sumber == "Ekskul") {
            $ekskul = SaldoEkskul::orderBy('id', 'desc')->first();
            $saldoEkskul = $ekskul->saldo;
            if ($saldoEkskul >= $jumlah) {
                    $saving = Saving::create([
                    'jumlah' => $request->jumlah,
                    'sumber' => "Ekskul",
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $newSaldoSaving = SaldoSaving::create([
                    'keluar_masuk' => 'M',
                    'jumlah_km' => $request->jumlah,
                    'desc' => 'Dari Ekskul',
                    'saldo' => $oldSaldoSaving + $jumlah,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $newSaldoEkskul = SaldoEkskul::create([
                    'keluar_masuk' => 'K',
                    'jumlah_km' => $request->jumlah,
                    'desc' => 'Pindah Ke Saving',
                    'saldo' => $saldoEkskul - $jumlah,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   return redirect()->route('savingIndex')->with('success', 'Berhasil Pindah !!');
            }else {
                return redirect()->route('savingIndex')->with('error', 'Saldo Kurang, Pilih Transaksi Lain !!');
            }
        }elseif ($sumber == "KegiatanSiswa") {
            $tranSiswa = MTranSiswa::where('id', $request->idKegiatan)->first();
            $saldoSiswa = $tranSiswa->saldo;
            if ($saldoSiswa >= $jumlah) {
                $saving = Saving::create([
                    'jumlah' => $request->jumlah,
                    'sumber' => $tranSiswa->name,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $newSaldoSaving = SaldoSaving::create([
                    'keluar_masuk' => 'M',
                    'jumlah_km' => $request->jumlah,
                    'desc' => 'Dari '. $tranSiswa->name,
                    'saldo' => $oldSaldoSaving + $jumlah,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $tranSiswa->update([
                    'saldo' => $saldoSiswa - $jumlah,
                   ]);
                   return redirect()->route('savingIndex')->with('success', 'Berhasil Pindah !!');
            }else {
                return redirect()->route('savingIndex')->with('error', 'Saldo Kurang, Pilih Transaksi Lain !!');
            }
        }else {
            $pemasukan = Pemasukan::where('id', $request->idPemasukan)->first();
            $saldoPemasukan = $pemasukan->jumlah;
            if ($saldoPemasukan >= $jumlah) {
                $saving = Saving::create([
                    'jumlah' => $request->jumlah,
                    'sumber' => $pemasukan->transaksi,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $newSaldoSaving = SaldoSaving::create([
                    'keluar_masuk' => 'M',
                    'jumlah_km' => $request->jumlah,
                    'desc' => 'Dari '. $pemasukan->transaksi,
                    'saldo' => $oldSaldoSaving + $jumlah,
                    'user' => Auth::user()->id,
                    'bulan' => $currentMonthName,
                    'tahun' => $currentYear,
                   ]);
                   $pemasukan->update([
                    'jumlah' => $saldoPemasukan -$jumlah,
                   ]);
                   return redirect()->route('savingIndex')->with('success', 'Berhasil Pindah !!');
            }else {
                return redirect()->route('savingIndex')->with('error', 'Saldo Kurang, Pilih Transaksi Lain !!');
            }
        }
    }
}
