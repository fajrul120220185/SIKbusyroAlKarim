<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPP extends Model
{
    use HasFactory;
    protected $table = 'spp';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'siswa_id',
        'name',
        'kelas_id',
        'kelas',
        'nis',
        'bulan',
        'tahun',
        'jumlah',
        'harus_bayar',
        'lunas',
        'bukti',
        'paid_at',
    ];
}
