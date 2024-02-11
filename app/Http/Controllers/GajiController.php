<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;

use App\Models\MGuru;
use App\Models\Gaji;
use App\Models\GrandSaldo;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($tahun = null)
    {
        $data['title'] = 'Gaji Guru';

        $tahun = $tahun ?? Carbon::now()->year;

        $guru = MGuru::all();
        $gajiGuru = Gaji::whereYear('tahun', $tahun)->get(); // Filtering data sebelum dikumpulkan

        $data['guruData'] = [];

        foreach ($guru as $guruItem) {
            $rowData = [
                'guru' => $guruItem,
                'gaji' => null,
                'bulan' => []
            ];

            foreach (range(1, 12) as $bulan) {
                $gajiPadaBulan = $gajiGuru
                    ->where('guru_id', $guruItem->id)
                    ->filter(function ($item) use ($bulan) {
                        return Carbon::parse($item->bulan)->month == $bulan;
                    })
                    ->first();

                $rowData['bulan'][$bulan] = [
                    'isPaid' => $gajiPadaBulan !== null,
                ];
                if ($gajiPadaBulan !== null) {
                    $rowData['gaji'] = $gajiPadaBulan->get();
                }
            }

            $data['guruData'][] = $rowData;
        }
    
        return view('transaksi.gaji.main', compact('tahun'))->with($data);
    }

    public function formGaji($guru, $tahun, $bulan)
    {
        $person = MGuru::where('id', $guru)->first();
        if ($person) {
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'data' =>$person]);
        }else {
            return response()->json(['success' => false ,'message' => 'updated successfully!']);
        }
    }

    public function Pay(Request $request)
    {
        $id = $request->id;
        $guru = MGuru::where('id', $id)->first();
        if ($guru) {
            $file = $request->bukti;
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $fileName = time() . $guru->name. $bulan. $tahun . $file->getClientOriginalName();
            $destination = 'uploads/gaji';

            $absoluteDestination = public_path($destination);
            if (!Storage::exists($destination)) {
                Storage::makeDirectory($destination, 0775, true); // Create the directory if it doesn't exist
            }

            $gaji = Gaji::create([
                'guru_id' => $guru->id,
                'nama' => $guru->name,
                'gaji' => $guru->gaji,
                'bonus' => $request->bonus,
                'ket_bonus' => $request->ket_bonus,
                'ket_potongan' => $request->ket_potongan,
                'potongan' => $request->potongan,
                'total' => $request->total,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'bukti' => $fileName,
                'paid_at' => $request->paid_at,
            ]);

            $grand = GrandSaldo::orderBy('id', 'desc')->first();
            if ($grand) {
                $saldo = $grand->saldo;
                $newSaldo = $saldo - $request->total;
                $newGrand = GrandSaldo::create([
                    'saldo' => $newSaldo
                ]);
            }

            $file->move($absoluteDestination, $fileName);
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'Saldo' =>$newGrand, 'data'=>$gaji]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function lihatBukti($guru, $tahun, $bulan)
    {
        // var_dump($guru, $bulan, $tahun);
        // die();
        $gaji = Gaji::where('guru_id', $guru)->where('bulan',$tahun)->where('tahun', $bulan)->first();
       
        if ($gaji) {
            return response()->json(['success' => true ,'message' => 'updated successfully!', 'data'=>$gaji]);
        }else {
            return response()->json(['success' => false ,'message' => 'Data Tidak Ditemukan!', 'data'=>$gaji, 'bulan' =>$bulan, 'tahun'=>$tahun]);

        }
    }

    public function Bukti($id)
    {
        $data['gaji'] = Gaji::where('id', $id)->first();
    
        return view('print.gaji')->with($data);
    }

}
