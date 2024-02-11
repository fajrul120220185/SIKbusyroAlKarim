<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\MSiswa;
use App\Models\MKelas;
use App\Models\SPP;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


use Auth;
class MasterSiswa implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $angkatan = $row['angkatan'];
            $tahunSekarang = Carbon::now()->year;
            $now = Carbon::now();
            $formattedDate = $now->format('Y-m-d H:i:s'); // Format tanggal
            $kelas = $row['kelas'];
            $class = substr($kelas, 0, 1); 
            $grade = substr($kelas, 1);
            $dataKelas = MKelas::where('kelas', $class)->where('grade', $grade)->first();
            $idKelas = $dataKelas->id;
            $hargaAPP = $dataKelas->tarif_spp;
            // Hitung selisih tahun
            $selisihTahun = $tahunSekarang - $angkatan;

            // Tentukan nilai untuk 'lulus' berdasarkan aturan
            $lulus = $selisihTahun >= 3 ? 'Y' : 'N';
            $siswa = MSiswa::create([
                'nis' => $row['nis'],
                'name' => $row['name'],
                'alamat' => $row['alamat'],
                'name_ortu' => $row['name_ortu'],
                'no_ortu' => $row['no_ortu'],
                'angkatan' => $angkatan,
                'kelas_id' =>$idKelas,
                'kelas' => $class,
                'grade' => $grade,
                'lulus' => $lulus,
                'yatim' => $row['yatim'],
                'created_at' => $formattedDate,
                'created_by' => Auth::user()->name,
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
           
        }
    }
}
