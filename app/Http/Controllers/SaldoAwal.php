<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SaldoSPP as SPP;
use App\Models\SaldoBOS as BOS;
use App\Models\SaldoEkskul as Ekskul;
use App\Models\SaldoSaving as Saving;
use Auth;


class SaldoAwal extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function saldoView()
    {
        $data['title'] = "Saldo Awal SMP IT Busyro Al-Karim";

        $spp = SPP::orderBy('id', 'desc')->first();
        if (!empty($spp)) {
            $data['saldoSpp'] = $spp->saldo;
        }else {
            $data['saldoSpp'] = null;
        }

        $bos = BOS::orderBy('id', 'desc')->first();
        if (!empty($bos)) {
            $data['saldoBos'] = $bos->saldo;
        }else {
            $data['saldoBos'] = null;
        }
        
        $ekskul = Ekskul::orderBy('id', 'desc')->first();
        if (!empty($ekskul)) {
            $data['saldoEkskul'] = $ekskul->saldo; 
        }else {
            $data['saldoEkskul'] = null;
        }

        $saving = Saving::orderBy('id', 'desc')->first();
        if (!empty($saving)) {
            $data['saldoSaving'] = $saving->saldo; 
        }else {
            $data['saldoSaving'] = null;
        }

        $data['user'] = Auth::user()->name;

        $currentMonthName = date('F');
        $currentYear = date('Y');

        $lastMonthName = date('F', strtotime('last month'));

        $sppKemarin = SPP::where('bulan', $lastMonthName)->orderBy('id', 'desc')->first();
        if (!empty($sppKemarin)) {
            $data['saldoSPPKemarin'] = $sppKemarin->saldo; 
        }else {
            $sppK = SPP::orderBy('id', 'desc')->first();
            if (!empty($sppK)) {
               $data['saldoSPPKemarin'] = $sppK->saldo;
            }else {
                $data['saldoSPPKemarin'] = null;
            }
        }

        $savingKemarin = Saving::where('bulan', $lastMonthName)->orderBy('id', 'desc')->first();
        if (!empty($savingKemarin)) {
            $data['saldoSavingKemarin'] = $savingKemarin->saldo; 
        }else {
            $sppK = Saving::orderBy('id', 'desc')->first();
            if (!empty($sppK)) {
               $data['saldoSavingKemarin'] = $sppK->saldo;
            }else {
                $data['saldoSavingKemarin'] = null;
            }
        }

        $bosKemarin = BOS::where('bulan', $lastMonthName)->orderBy('id', 'desc')->first();
        if (!empty($bosKemarin)) {
            $data['saldoBOSKemarin'] = $bosKemarin->saldo; 
        }else {
            $sppK = BOS::orderBy('id', 'desc')->first();
            if (!empty($sppK)) {
               $data['saldoBOSKemarin'] = $sppK->saldo;
            }else {
                $data['saldoBOSKemarin'] = null;
            }
        }

        $ekskulKemarin = Ekskul::where('bulan', $lastMonthName)->orderBy('id', 'desc')->first();
        if (!empty($ekskulKemarin)) {
            $data['saldoEkskulKemarin'] = $ekskulKemarin->saldo; 
        }else {
            $sppK = Ekskul::orderBy('id', 'desc')->first();
            if (!empty($sppK)) {
               $data['saldoEkskulKemarin'] = $sppK->saldo;
            }else {
                $data['saldoEkskulKemarin'] = null;
            }
        }
        
        return view('saldo.main', $data);
    }

    public function saldoAwalLogin(Request $request)
    {
        $pass = $request->password;
        $access = "FYENNY77";

        if ($pass == $access) {
            return redirect()->route('saldoView')->with('success', 'Selamat Datang');

        }else {
            return redirect()->back()->with('error', 'Password Salah!!');

        }
    }

    public function SPPlogin(Request $request)
    {
        $pass = $request->password;
        if ($pass == "FYENNY77") {
            
            return response()->json([
                'success' => true ,
                'message' => 'Password Benar!',
                ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pasword Salah',
            ]);
        }
    }

    public function InputSaldo(Request $request)
    {
        if ($request->tujuan == 'SPP') {
            $tujuan = new SPP;
        }elseif ($request->tujuan =='BOS') {
            $tujuan = new BOS;
        }elseif ($request->tujuan == 'Ekskul') {
            $tujuan = new Ekskul;
        }else {
            $tujuan = new Saving;
        }
        $currentMonthName = date('F');
        $currentYear = date('Y');

        $saldo = $tujuan->create([
            'keluar_masuk' => 'M',
            'jumlah_km' => $request->saldo,
            'desc' => 'Input Saldo Awal',
            'saldo' => $request->saldo,
            'user' => Auth::user()->id,
            'bulan' => $currentMonthName,
            'tahun' => $currentYear,
        ]);

        return redirect()->route('saldoView')->with('success', 'Saldo Berhasil di Input');
    }

    public function trackingSaldo(Request $request)
    {
        $data['title'] = "Tracking Saldo " . $request->tujuanTracking;
        $tujuan = $request->tujuanTracking;

        if ($tujuan == "Saving") {
            $data['saldo'] = Saving::get();
        }elseif ($tujuan == "SPP") {
            $data['saldo'] = SPP::get();
        }elseif ($tujuan == "BOS") {
            $data['saldo'] = BOS::get();
        }elseif ($tujuan == "Ekskul") {
            $data['saldo'] = Ekskul::get();
        }

        return view('saldo.tracking', $data);
    }
}
