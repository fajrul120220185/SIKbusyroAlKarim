<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;

use App\Models\Pemasukan;
use App\Models\Mtransaksi;
use App\Models\GrandSaldo;

class PemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
        $data['title'] = "Pemasukan";
        $data['pemasukan'] = Pemasukan::get();
        $data['transaksi'] = Mtransaksi::where('jenis', '=', 'pemasukan')->get();
        return view('transaksi.pemasukan.main')->with($data);
    }
    public function post(Request $request)
    {   
        $grand = GrandSaldo::orderBy('id', 'desc')->first();
       
        if ($grand) {
            $id_transaksi = $request->id_transaksi;
            $transaksi = Mtransaksi::where('id', $id_transaksi)->first();
            $file = $request->bukti;
            $fileName = time() . $transaksi->nama . $file->getClientOriginalName();
            $destination = 'uploads/pemasukan';

            $absoluteDestination = public_path($destination);
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
            }
            
            $pengeluaran = Pemasukan::create([
                    'id_transaksi'=>$request->id_transaksi,
                    'transaksi'=>$transaksi->nama,
                    'jumlah'=>$request->jumlah,
                    'bukti'=>$fileName,
                    'tanggal'=>$request->tanggal,
                    'desc'=>$request->desc,
            ]);
            $lastSaldo = $grand->saldo;
            $saldo = $lastSaldo + $request->jumlah;
            // var_dump($saldo);
            // die();
            $newSaldo = GrandSaldo::create([
                'saldo' => $saldo
            ]);
            $file->move($absoluteDestination, $fileName);
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$grand]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function edit($id)
    {
        $pengeluaran = Pemasukan::where('id', $id)->first();
        if ($pengeluaran) {
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'data' =>$pengeluaran]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function update(Request $request)
    {   
        $id = $request->id;
        $DataPengeluaran = Pemasukan::where('id', $id)->first();
        if ($DataPengeluaran) {
            $grand = GrandSaldo::orderBy('id', 'desc')->first();

            if ($grand) {
                $id_transaksi = $request->id_transaksi;
                $transaksi = Mtransaksi::where('id', $id_transaksi)->first();
                $file = $request->bukti;
                if ($file !== null && is_a($file, 'Illuminate\Http\UploadedFile') && $file->isValid()) {
                    $fileName = time() . $transaksi->nama . $file->getClientOriginalName();
                    $destination = 'uploads/pemasukan';
                
                    $absoluteDestination = public_path($destination);
                    if (!Storage::exists($destination)) {
                        Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
                    }

                    $kalkulasi = $DataPengeluaran->jumlah;
                    $jumlah = $request->jumlah;
                    if ($kalkulasi > $jumlah) {
                        $newJumlah = $kalkulasi - $jumlah;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo - $newJumlah; 
                    }elseif ($kalkulasi < $jumlah) {
                        $newJumlah = $jumlah - $kalkulasi;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo + $newJumlah; 
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
                        $saldo = $lastSaldo - $newJumlah; 
                    }elseif ($kalkulasi < $jumlah) {
                        $newJumlah = $jumlah - $kalkulasi;
                        $lastSaldo = $grand->saldo;
                        $saldo = $lastSaldo + $newJumlah; 
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
        $pengeluaran = Pemasukan::where('id', $id)->first();
        if ($pengeluaran) {
            $grand = GrandSaldo::orderBy('id', 'desc')->first();
            $PSaldo = $pengeluaran->jumlah;
            $saldo = $grand->saldo - $PSaldo;
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
