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

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($startDate, $endDate)
    {

        $data['title'] = "Report Transaksi";
        $date = $startDate . '-' . $endDate;

        list($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) = explode('-', $date);
        // Format the date for daterangepicker (MM/DD/YYYY)
        $formattedStartDate = sprintf('%02d/%02d/%04d', $startMonth, $startDay, $startYear);
        $formattedEndDate = sprintf('%02d/%02d/%04d', $endMonth, $endDay, $endYear);

        $data['pemasukan'] = Pemasukan::where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate)->orderBy('tanggal', 'asc')->orderBy('transaksi', 'asc')->get();
        $pemasukanTotal = $data['pemasukan']->sum('jumlah');
        $transaksi_siswaS = TranSis::select('trans_id', TranSis::raw('MAX(id) as max_id'))
        ->where('paid_at', '>=', $startDate)
        ->where('paid_at', '<=', $endDate)
        ->groupBy('trans_id')
        ->get();
    
    // Mengambil data lengkap berdasarkan max_id
        $data['transaksi_siswa'] = TranSis::whereIn('id', $transaksi_siswaS->pluck('max_id'))->get();
        $totalJumlahPerTransId = $data['transaksi_siswa']->pluck('jumlah');
        $totalJumlahSemuaTransaksi = $totalJumlahPerTransId->sum();

        $spp = SPP::where('paid_at', '>=', $startDate)->where('paid_at', '<=', $endDate)->get();
        $data['totalSPP'] = $spp->sum('jumlah');

        $data['totalPemasukan'] = $pemasukanTotal + $data['totalSPP'] + $totalJumlahSemuaTransaksi;


        $data['pengeluaran'] = Pengeluaran::where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate)->orderBy('tanggal', 'asc')->orderBy('transaksi', 'asc')->get();
        $pengeluaranTotal = $data['pengeluaran']->sum('jumlah');
        $gaji = Gaji::where('paid_at', '>=', $startDate)->where('paid_at', '<=', $endDate)->get();
        $data['totalGaji'] = $gaji->sum('total');
        $data['totalPengeluaran'] = $pengeluaranTotal + $data['totalGaji'];

        $data['totalTrans'] =  $data['totalPemasukan'] - $data['totalPengeluaran'];
        $data['GS'] = GrandSaldo::orderBy('id', 'desc')->first();

        $grandSaldo = $data['GS']->saldo;

        $data['totalSebelumnya'] = $grandSaldo - $data['totalTrans'];
        $data['terbilang'] = $this->terbilang($data['GS']->saldo);

        return view('report.main', compact('formattedStartDate', 'formattedEndDate', 'totalJumlahSemuaTransaksi'))->with($data);
    }
        
    public function search (Request $request)
    {
        $time = $request->time;

        list($startDate, $endDate) = explode(' - ', $time);

        // Format the dates if needed
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        var_dump($startDate, $endDate);
        die();
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
