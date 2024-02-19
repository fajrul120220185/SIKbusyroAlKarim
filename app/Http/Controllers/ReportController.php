<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\TransaksiSiswa as TranSis;
use App\Models\MTranSiswa;
use App\Models\SPP;
use App\Models\Gaji;
use App\Models\GrandSaldo;
use App\Models\SaldoSPP;
use App\Models\SaldoBOS;
use App\Models\SaldoEkskul;
use App\Models\SaldoSaving;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {

        $data['title'] = "Report Transaksi";
        
        $spp = SaldoSpp::orderBy('id', 'desc')->first();
        $saldoSPP = $spp->saldo;
        $bos = SaldoBos::orderBy('id', 'desc')->first();
        $saldoBOS = $bos->saldo;
        $saving = SaldoSaving::orderBy('id', 'desc')->first();
        $saldoSaving = $saving->saldo;
        $ekskul = SaldoEkskul::orderBy('id', 'desc')->first();
        $saldoEkskul = $ekskul->saldo;
        $pemasukan = Pemasukan::get();
        $saldoPemasukan = $pemasukan->sum('jumlah');
        $kegiatan = MTranSiswa::get();
        $saldoKegiatan = $kegiatan->sum('saldo');

        $data['saldoTotal'] = $saldoSPP + $saldoBOS + $saldoEkskul + $saldoSaving + $saldoPemasukan + $saldoKegiatan;
        $data['terbilang'] = $this->terbilang($data['saldoTotal']);

        return view('report.main', compact('saldoSPP' , 'saldoBOS' , 'saldoEkskul' , 'saldoSaving' , 'saldoPemasukan' , 'saldoKegiatan'))->with($data);
    }
        
    public function search (Request $request)
    {
        $data['title'] = "Laporan Bulan " . $request->bulan . '-' . $request->tahun;

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $bulanNumerik = Carbon::parse("1 $bulan")->month;
        $lastMonthName = date('F', strtotime('last month', strtotime($bulan)));
        $data['bulanLalu'] = $lastMonthName;

        // SPP
        $spp = SaldoSPP::where('keluar_masuk', '=', 'M')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['saldoSPP'] = $spp->sum('jumlah_km');
        $data['saldoSPPKemarin'] =  SaldoSPP::where('bulan', $lastMonthName)->where('tahun', $tahun)->orderBy('id', 'desc')->first();
        $pengeluaranSPP = SaldoSPP::where('keluar_masuk', '=', 'K')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['keluarSPP'] = $pengeluaranSPP->sum('jumlah_km');


        // EKSKUL
        $ekskul = SaldoEkskul::where('keluar_masuk', '=', 'M')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['saldoEkskul'] = $ekskul->sum('jumlah_km');
        $data['saldoEkskulKemarin'] =  SaldoEkskul::where('bulan', $lastMonthName)->where('tahun', $tahun)->orderBy('id', 'desc')->first();
        $pengeluaranEkskul = SaldoEkskul::where('keluar_masuk', '=', 'K')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['keluarEkskul'] = $pengeluaranEkskul->sum('jumlah_km');

        // BOS
        $bos = SaldoBOS::where('keluar_masuk', '=', 'M')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['saldoBos'] = $bos->sum('jumlah_km');
        $data['saldoBosKemarin'] =  SaldoBOS::where('bulan', $lastMonthName)->where('tahun', $tahun)->orderBy('id', 'desc')->first();
        $pengeluaranEkskul = SaldoBOS::where('keluar_masuk', '=', 'K')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['keluarBos'] = $pengeluaranEkskul->sum('jumlah_km');

        $pemasukan = Pemasukan::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulanNumerik)->get();
        $data['saldoPemasukan'] = $pemasukan->sum('jumlah_diterima');

        $pengeluaran = Pengeluaran::whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulanNumerik)->whereNotIn('sumber', ['Saving', 'SPP', 'BOS', 'Ekskul'])->where('sumber', 'not like', 'Kegiatan Siswa%')->get();
        $data['saldoPengeluaran'] = $pengeluaran->sum('jumlah');

        // TotMasuk
        $data['totalPemasukan'] = $data['saldoSPP'] + ($data['saldoSPPKemarin'] ? $data['saldoSPPKemarin']->saldo : 0) + $data['saldoEkskul'] +  ($data['saldoEkskulKemarin'] ? $data['saldoEkskulKemarin']->saldo : 0) + $data['saldoBos'] + ($data['saldoBosKemarin'] ? $data['saldoBosKemarin']->saldo : 0) + $data['saldoPemasukan'];
        $data['terbilangMasuk'] = $this->terbilang($data['totalPemasukan']);
        
        // TotKeluar
        $data['totalPengeluaran'] = $data['keluarSPP'] + $data['keluarEkskul'] +  $data['keluarBos'] +  $data['saldoPengeluaran'];
        $data['terbilangKeluar'] = $this->terbilang($data['totalPengeluaran']);

        // Laporan Saving
        $savingLalu = SaldoSaving::where('bulan', $lastMonthName)->orderBy('id', 'desc')->first();
        if ($savingLalu) {
            $data['saldoAwalSaving'] = $savingLalu->saldo;
        } else {
            $data['saldoAwalSaving'] = 0;
        }
        $data['savingMasuk'] = SaldoSaving::where('keluar_masuk', '=', 'M')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['saldoSavingMasuk'] = $data['savingMasuk']->sum('jumlah_km');

        $data['savingKeluar'] = SaldoSaving::where('keluar_masuk', '=', 'K')->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $data['saldoSavingKeluar'] = $data['savingKeluar']->sum('jumlah_km');



        return view('report.report-all', compact('bulan', 'tahun'), $data);
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
