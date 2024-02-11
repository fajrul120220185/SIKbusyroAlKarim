<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSiswa extends Model
{
    use HasFactory;

    protected $table = 'transaksi_siswa';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'trans_id',
        'siswa_id',
        'trans_name',
        'siswa_name',
        'nis',
        'kelas_id',
        'kelas',
        'grade',
        'jumlah',
        'kurang',
        'harus_bayar',
        'lunas',
        'paid_at',
        'lunas_at',
    ];
}
