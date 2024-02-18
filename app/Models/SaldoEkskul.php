<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoEkskul extends Model
{
    use HasFactory;
    protected $table = 'saldo_ekskul';
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
