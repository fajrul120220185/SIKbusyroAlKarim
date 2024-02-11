<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSiswa extends Model
{
    use HasFactory;
    protected $table = 'msiswa';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
    'nis',
    'name',
    'alamat',
    'name_ortu',
    'no_ortu',
    'angkatan',
    'kelas_id',
    'kelas',
    'grade',
    'yatim',
    'lulus',
    'created_by',
    'update_by',
    'created_at',
    ];

    public function sppRecords()
    {
        return $this->hasMany(SPP::class, 'siswa_id', 'id');
    }

    public function transRecords()
    {
        return $this->hasMany(TransaksiSiswa::class, 'siswa_id', 'id');
    }

}
