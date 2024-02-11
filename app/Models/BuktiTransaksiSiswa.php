<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiTransaksiSiswa extends Model
{
    use HasFactory;

    protected $table = 'bukti_transaksi_siswa';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'trans_id',
        'bukti',
        'paid_at',
    ];
}
