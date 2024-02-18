<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Models\DanaBos;
use App\Models\SaldoBOS;

class BosController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dana BOS';

        $data['laporanBos'] = DanaBos::orderBy('tgl_masuk', 'asc')->get();
        $bos = SaldoBOS::orderBy('id', 'desc')->first();
        $data['saldoBos'] = $bos->saldo; 
        return view('bos.main', $data);
    }

    public function store(Request $request)
    {
        $bosBefore = SaldoBOS::orderBy('id', 'desc')->first();
        if ($bosBefore) {
            $danaBefore = $bosBefore->saldo;
            $newDana = $request->jumlah + $danaBefore;

            $currentMonthName = date('F');
            $currentYear = date('Y');

            $bos = DanaBos::create([
                'jumlah' => $request->jumlah,
                'user' => Auth::user()->id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
            ]);

            $updateSaldo = SaldoBOS::create([
                'keluar_masuk' => 'M',
                'jumlah_km' => $request->jumlah,
                'desc' => 'Input Pemasukan BOS Bulan ' . $request->bulan . '-' . $request->tahun,
                'saldo' => $newDana,
                'user' => Auth::user()->id,
                'bulan' => $currentMonthName,
                'tahun' => $currentYear,
            ]);
            return redirect()->route('bosIndex')->with('success', 'Saldo Berhasil di Input');
        }else {
            return redirect()->route('bosIndex')->with('error', 'Terjadi Kesalahan, Hubungi Admin !!');

        }
        
    }
}
