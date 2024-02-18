<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'id_transaksi',
        'transaksi',
        'desc',
        'jumlah_diterima',
        'jumlah',
        'bukti',
        'tanggal',
    ];
}
