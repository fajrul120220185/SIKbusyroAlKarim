<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    use HasFactory;

    protected $table = 'kwitansi';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'trans_id',
        'siswa_id',
        'transaksi',
        'siswa_name',
        'nis',
        'kelas',
        'jumlah',
        'lunas',
        'paid_at',
    ];
}
