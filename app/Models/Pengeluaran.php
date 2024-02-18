<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'id_transaksi',
        'transaksi',
        'desc',
        'jumlah',
        'sumber',
        'bukti',
        'tanggal',
    ];
}
