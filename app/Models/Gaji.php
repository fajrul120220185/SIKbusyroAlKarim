<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'guru_id',
        'nama',
        'gaji',
        'ket_bonus',
        'bonus',
        'ket_potongan',
        'potongan',
        'total',
        'bulan',
        'tahun',
        'bukti',
        'paid_at',
    ];
}
