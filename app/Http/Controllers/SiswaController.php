<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MasterSiswa;

use App\Models\Msiswa;
use App\Models\MKelas;
use App\Models\SPP;

class SiswaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function Main()
    {

        $data['siswa'] = Msiswa::where('lulus', '=', 'N')->orderBy('kelas', 'asc')->get();
        $data['kelas'] = MKelas::orderBy('kelas', 'asc')->get();
        $data['title'] = 'Master Siswa';
        return view('master.siswa.main')->with($data);
    }

    public function Store (Request $request)
    {
        $now = Carbon::now();
        $formattedDate = $now->format('Y-m-d H:i:s'); // Format tanggal
        $kelas_id = $request->kelas;
        $kelas = MKelas::where('id', $kelas_id)->first();
        $hargaAPP = $kelas->tarif_spp;

        $kelasName = $kelas->kelas;
        $grade = $kelas->grade;
        $tahunSekarang = Carbon::now()->year;

        $siswa = MSiswa::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'name_ortu' => $request->name_ortu,
            'no_ortu' => $request->no_ortu,
            'angkatan' => $request->angkatan,
            'kelas_id' => $request->kelas,
            'kelas' => $kelasName,
            'grade' => $grade,
            'yatim' => $request->yatim,
            'created_by' => Auth::user()->name,
            'created_at' => $formattedDate,
            'lulus' => 'N',
        ]);

       if ($siswa->yatim == 'N') {
        for ($month = 7; $month <= 12; $month++) {
            $date = Carbon::createFromDate($tahunSekarang, $month, 1);

            SPP::create([
                'siswa_id' => $siswa->id,
                'name' => $siswa->name,
                'kelas_id' => $siswa->kelas_id,
                'kelas' => $siswa->kelas,
                'nis' => $siswa->nis,
                'bulan' => $date->formatLocalized('%B'), // Month name
                'tahun' => $date->format('Y'), // Year
                'jumlah' => 0, // Initial value
                'harus_bayar' => $hargaAPP,
                'lunas' => 'N', // Initially not paid
                'bukti' => null, // Initially no proof
                'paid_at' => null, // Initially not paid
            ]);
        }

        // Create records for January to June of the next year
        for ($month = 1; $month <= 6; $month++) {
            $date = Carbon::createFromDate($tahunSekarang + 1, $month, 1);

            SPP::create([
                'siswa_id' => $siswa->id,
                'name' => $siswa->name,
                'kelas_id' => $siswa->kelas_id,
                'kelas' => $siswa->kelas,
                'nis' => $siswa->nis,
                'bulan' => $date->formatLocalized('%B'), // Month name
                'tahun' => $date->format('Y'), // Year
                'jumlah' => 0, // Initial value
                'harus_bayar' => $hargaAPP,
                'lunas' => 'N', // Initially not paid
                'bukti' => null, // Initially no proof
                'paid_at' => null, // Initially not paid
            ]);
        }
       }

        return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $siswa]);
    }

    public function Edit ($id)
    {
        $siswa = MSiswa::where('id', $id)->first();
        if ($siswa) {
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $siswa]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function Update(Request $request)
    {
        $id = $request->id;
        $kelas_id = $request->kelas;
        $kelas = MKelas::where('id', $kelas_id)->first();
        $hargaAPP = $kelas->tarif_spp;

        $tahunSekarang = Carbon::now()->year;

        $kelasName = $kelas->kelas;
        $grade = $kelas->grade;
        $siswa = MSiswa::where('id', $id)->first();
        $oldKelas = $siswa->kelas;
        if ($siswa) {
           $siswa->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'name_ortu' => $request->name_ortu,
            'no_ortu' => $request->no_ortu,
            'angkatan' => $request->angkatan,
            'kelas_id' => $request->kelas,
            'kelas' => $kelasName,
            'grade' => $grade,
            'yatim' => $request->yatim,
            'update_by' => Auth::user()->name,
           ]);

           if (($kelasName != $oldKelas) && ($siswa->yatim == 'N')) {
            if ($siswa->yatim == 'N') {
                $oldSPP = SPP::where('siswa_id', $siswa->id)->where('kelas', $kelasName)->first();
                if ($oldSPP) {
                    # code...
                }
                else {
                    for ($month = 7; $month <= 12; $month++) {
                        $date = Carbon::createFromDate($tahunSekarang, $month, 1);
            
                        SPP::create([
                            'siswa_id' => $siswa->id,
                            'name' => $siswa->name,
                            'kelas_id' => $siswa->kelas_id,
                            'kelas' => $siswa->kelas,
                            'nis' => $siswa->nis,
                            'bulan' => $date->formatLocalized('%B'), // Month name
                            'tahun' => $date->format('Y'), // Year
                            'jumlah' => 0, // Initial value
                            'harus_bayar' => $hargaAPP,
                            'lunas' => 'N', // Initially not paid
                            'bukti' => null, // Initially no proof
                            'paid_at' => null, // Initially not paid
                        ]);
                    }
            
                    // Create records for January to June of the next year
                    for ($month = 1; $month <= 6; $month++) {
                        $date = Carbon::createFromDate($tahunSekarang + 1, $month, 1);
            
                        SPP::create([
                            'siswa_id' => $siswa->id,
                            'name' => $siswa->name,
                            'kelas_id' => $siswa->kelas_id,
                            'kelas' => $siswa->kelas,
                            'nis' => $siswa->nis,
                            'bulan' => $date->formatLocalized('%B'), // Month name
                            'tahun' => $date->format('Y'), // Year
                            'jumlah' => 0, // Initial value
                            'harus_bayar' => $hargaAPP,
                            'lunas' => 'N', // Initially not paid
                            'bukti' => null, // Initially no proof
                            'paid_at' => null, // Initially not paid
                        ]);
                    }
                }
               }
           }
           return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $siswa]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }

    public function Delete($id)
    {
        $siswa = MSiswa::where('id', $id)->first();
        if ($siswa) {
            $siswa->delete();

            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function Excel(Request $request)
    {
        $path = $request->file('file');
        Excel::import(new MasterSiswa, $path->getRealPath(), null, 'Xlsx');

        return redirect()->back()->with('success', 'Data berhasil diimpor.');


    }
}
