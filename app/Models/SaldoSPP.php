<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoSPP extends Model
{
    use HasFactory;
    protected $table = 'saldo_spp';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'keluar_masuk',
        'jumlah_km',
        'desc',
        'saldo',
        'user',
        'bulan',
        'tahun',
    ];
}
