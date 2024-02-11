<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\Models\Msiswa;
use App\Models\MKelas;
use App\Models\SPP;
use App\Models\TransaksiSiswa;
use App\Models\GrandSaldo;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($siswa = null)
    {
        $data['siswa'] = $siswa;
        if ($data['siswa'] == null) {
            $data['title'] = "Menu Pembayaran Siswa";
        }
        else {
            $data['siswaInP'] = MSiswa::where('id', $siswa)->first();
            $data['title'] = "Menu Pembayaran Siswa " . $data['siswaInP']->name;

            $data['SPP'] = SPP::where('siswa_id', $siswa)->orderBy('lunas', 'asc')->orderBy('tahun', 'asc')->orderByRaw("FIELD(bulan, 'January', 'February', 'March', 'April', 'May', 'Junr', 'July', 'August', 'September', 'October', 'November', 'December')")->orderBy('kelas', 'asc')->get();
            $data['TransSiswa'] = TransaksiSiswa::where('siswa_id', $siswa)->orderBy('Lunas', 'asc')->get();

            $data['tagihanSPP'] = SPP::where('siswa_id', $siswa)->where('lunas', '=', 'N')->get();
            $data['tagihanKegiatan'] = TransaksiSiswa::where('siswa_id', $siswa)->where('lunas', '=', 'N')->get();
            $data['kwitansiSPP'] = SPP::where('siswa_id', $siswa)->where('lunas', '=', 'Y')->get();
            $data['kwitansiKegiatan'] = TransaksiSiswa::where('siswa_id', $siswa)->whereNotNull('paid_at')->get();
        }
    
        $data['siswaPilih'] = MSiswa::whereNot('lulus', '=', 'Y')
                                ->orderBy('kelas', 'asc')
                                ->orderBy('grade', 'asc')
                                ->orderBy('nis', 'asc')
                                ->get();



        return view('pembayaran-siswa.main')->with($data);
    }

    public function tagihan($spp, $kegiatan, $siswa)
    {
        $sppIds = $spp ? explode(',', $spp) : [];
    $kegiatanIds = $kegiatan ? explode(',', $kegiatan) : [];
    
    $data['spp'] = $sppIds ? SPP::whereIn('id', $sppIds)->get() : [];
    $data['kegiatan'] = $kegiatanIds ? TransaksiSiswa::whereIn('id', $kegiatanIds)->get() : [];
    
    if ($data['kegiatan'] != null) {
        $data['harusBayarKegiatan'] = $data['kegiatan']->sum('kurang');
    }else {
        $data['harusBayarKegiatan'] = 0;
    }

    if ($data['spp'] != null) {
        $data['harusBayarSpp'] = $data['spp']->sum('harus_bayar');
    }else {
        $data['harusBayarSpp'] = 0;

    }
    
    $data['harusBayarTotal'] = $data['harusBayarKegiatan'] + $data['harusBayarSpp'];
    $data['siswa'] = MSiswa::where('id', $siswa)->first();

    // dd($data['spp'], $data['kegiatan']);

        return view('print.pembayaran-siswa.tagihan')->with($data);
    }

    public function getData(Request $request)
    {
        $siswa_id = $request->input('siswa');
        $transis_id = $request->input('transis');
        $spp = $request->input('spp');
    
        // Simpan data dalam sesi
        $request->session()->put('siswa_id', $siswa_id);
        $request->session()->put('transis_id', $transis_id);
        $request->session()->put('spp', $spp);

        return redirect()->route('prosesBayar');
    }

    public function prosesBayar (Request $request)
    {
    $siswa_id = $request->session()->get('siswa_id');
    $siswa = MSiswa::where('id', $siswa_id)->first();
    $data['title'] = "Pembayaran" . $siswa->name;

    $transis_id = $request->session()->get('transis_id');
    $spp = $request->session()->get('spp');

    if (is_string($spp)) {
        $spp = explode(',', $spp);
    }

    if (is_string($transis_id)) {
        $transis_id = explode(',', $transis_id);
    }

    if ($spp != null) {
        $data['bayarSPP'] = SPP::whereIn('id', $spp)->get();
    }else {
        $data['bayarSPP'] = null;
    }

    if ($transis_id != null) {
        $data['kegiatan'] = TransaksiSiswa::whereIn('id', $transis_id)->get();

    }else {
        $data['kegiatan'] = null;
    }
   

    // dd($spp);
    return view('pembayaran-siswa.pay', compact('siswa_id'))->with($data);
    }

    public function PaySiswa(Request $request)
    {
        $idSPP = $request->spp_id;
        $transId = $request->trans_id;

        // dd($idSPP, $transId);
        if (!empty($idSPP)) {
            foreach ($idSPP as $sppId) {
                $spp = SPP::where('id', $sppId)->first();
                if ($spp) {
                    $spp->update([
                        'jumlah' => $spp->harus_bayar,
                        'lunas' => 'Y',
                    ]);
                }
                $saldo  = GrandSaldo::orderBy('id', 'desc')->first();
                $lastSaldo = $saldo->saldo;
                $newSaldo = $lastSaldo + $spp->harus_bayar;
                $Grs = GrandSaldo::create([
                    'saldo'=>$newSaldo
                ]);
            }
        }
       

        if (!empty($transId)) {
            foreach ($transId as $trans) {
                $kegiatan = TransaksiSiswa::where('id', $trans)->first();
                if ($kegiatan) {
                    $harusBayar = $kegiatan->harus_bayar;
                    $oldJumlah = $kegiatan->jumlah;
                    $kurang = $kegiatan->kurang;
                    $jumlah = $request->input('jumlah'.$trans);
    
                    $newKurang =  $harusBayar - ($oldJumlah + $jumlah);
    
                    if ($kurang == 0) {
                        $lunas = "Y";
                        $lunas_at = Carbon::now();
                    }else {
                        $lunas = "N";
                        $lunas_at = NULL;
                    }
    
                    $kegiatan->update([
                        'jumlah' => $oldJumlah + $jumlah,
                        'kurang' => $newKurang,
                        'lunas' => $lunas,
                        'lunas_at' => $lunas_at,
                    ]);
                    $saldo  = GrandSaldo::orderBy('id', 'desc')->first();
                    $lastSaldo = $saldo->saldo;
                    $newSaldo = $lastSaldo + $jumlah;
                    $Grs = GrandSaldo::create([
                        'saldo'=>$newSaldo
                    ]);
                }
            }
        }
        $siswa = $request->siswa_id;

        // dd($siswa);

        return redirect()->route('pembayaran-siswa', ['siswa' => $siswa])->with('success', 'Pembayaran berhasil!');


    }

    public function kwitansi($spp, $kegiatan, $siswa)
    {
        $sppIds = $spp ? explode(',', $spp) : [];
    $kegiatanIds = $kegiatan ? explode(',', $kegiatan) : [];
    
    $data['spp'] = $sppIds ? SPP::whereIn('id', $sppIds)->get() : [];
    $data['kegiatan'] = $kegiatanIds ? TransaksiSiswa::whereIn('id', $kegiatanIds)->get() : [];
    
    if ($data['kegiatan'] != null) {
        $data['harusBayarKegiatan'] = $data['kegiatan']->sum('jumlah');
    }else {
        $data['harusBayarKegiatan'] = 0;
    }

    if ($data['spp'] != null) {
        $data['harusBayarSpp'] = $data['spp']->sum('jumlah');
    }else {
        $data['harusBayarSpp'] = 0;

    }
    
    $data['harusBayarTotal'] = $data['harusBayarKegiatan'] + $data['harusBayarSpp'];
    $data['siswa'] = MSiswa::where('id', $siswa)->first();

    // dd($data['spp'], $data['kegiatan']);

        return view('print.pembayaran-siswa.kwitansi')->with($data);
    }

}
