<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MKelas;
use App\Models\MGuru;
use App\Models\MSiswa;
use Carbon\Carbon;

use App\Models\SPP;


class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function Main()
    {
        $data['title'] = 'Master Guru';
        
        $data['guru'] = MGuru::get();
        $data['kelas'] = MKelas::orderBy('kelas', 'asc')->get();

        return view('master.kelas.main')->with($data);
    }

    public function Store(Request $request)
    {
        $id_guru = $request->id_guru;

        $guru = MGuru::where('id', $id_guru)->first();
        $namaKelas = $request->kelas;
        $class = substr($namaKelas, 0, 1); 
        $grade = substr($namaKelas, 1);        
        if ($guru) {
            $kelas = MKelas::create([
                'kelas' => $class,
                'grade' =>$grade,
                'guru_id' => $guru->id,
                'walikelas' => $guru->name,
                'tarif_spp' => $request->tarif_spp,
            ]);
    
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'=> $kelas,]);
        }else {
            return response()->json(['success' => false ,'message' => 'data tidak ditmukan']);        }
        
    }

    public function Edit ($id)
    {
        $kelas = MKelas::where('id', $id)->first();
        if ($kelas) {
            return response()->json(['success' => true ,'message' => 'updated successfully!','data'  => $kelas,]);
        }else {
            return response()->json(['success' => false ,'message' => 'data tidak ditmukan']);
        }
    }

    public function Update(Request $request)
    {
        $id = $request->id;

        $kelas = MKelas::where('id', $id)->first();
        if ($kelas) {
            $id_guru = $request->id_guru;

            $guru = MGuru::where('id', $id_guru)->first();
            $namaKelas = $request->kelas;
            $class = substr($namaKelas, 0, 1); 
            $grade = substr($namaKelas, 1);      

            $kelas ->update([
                'kelas' => $class,
                'grade' =>$grade,
                'guru_id' => $guru->id,
                'walikelas' => $guru->name,
                'tarif_spp' => $request->tarif_spp,

            ]);
            
        return response()->json(['success' => true ,'message' => 'updated successfully!','data'    => $kelas,]);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function Delete($id)
    {
        $kelas = MKelas::where('id', $id)->first();
        if ($kelas) {
            $kelas->delete();

            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong']);
        }
    }

    public function ListView($id)
    {
       $kelasView = MKelas::where('id', $id)->first();
        // dd($id);
        $data['title'] = 'Kelas ' . $kelasView->kelas . $kelasView->grade;
        
        $data['siswa'] = MSiswa::where('kelas_id', $id)->orderBy('name', 'asc')->get();
        $data['id'] = $id;
        $data['kelas'] = MKelas::whereNot('id',$id)->get();
        $data['addSiswa'] = Msiswa::whereNot('kelas_id', $id)->where('lulus', '=', 'N' )->get();


        return view('kelas.main')->with($data);
    }

    public function addSiswa(Request $request)
    {
        $id = $request->id;
        $kel = MKelas::where('id', $request->kelas)->first();
        $hargaAPP = $kel->tarif_spp;

        $tahunSekarang = Carbon::now()->year;


        $kelas = $kel->kelas;
        $grade = $kel->grade;
        // var_dump($id);
        // die();
        if ($kel) {
            foreach ($id as $id) {
                $siswa = MSiswa::where('id', $id)->first();
                $oldKelas = $siswa->kelas;
                if ($siswa) {
                    $siswa->update([
                        'kelas_id' => $request->kelas,
                        'kelas' => $kelas,
                        'grade' => $grade,
                    ]);

                    if (($kelas != $oldKelas) && ($siswa->yatim == 'N')) {
                        if ($siswa->yatim == 'N') {
                            $oldSPP = SPP::where('siswa_id', $siswa->id)->where('kelas', $kelas)->first();
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
                }
            }
            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
       
    }

    public function moveSiswa(Request $request)
    {
        $id = $request->id;
        $siswa = MSiswa::where('id', $id)->first();

        // var_dump($siswa);
        // die();
        if ($siswa) {
            $kelas = $request->kelas;
            if ($kelas == 'lulus') {
                $siswa->update([
                    'kelas' => null,
                    'lulus' => 'Y',
                ]);
            }else {
                $siswa->update([
                    'kelas' =>$kelas,
                ]);
            }
            return response()->json(['success' => true ,'message' => 'updated successfully!']);
        }else {
            return response()->json(['success' => false ,'message' => 'Something Wrong!']);
        }
    }
}
