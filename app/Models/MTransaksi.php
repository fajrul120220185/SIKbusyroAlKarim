<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTransaksi extends Model
{
    use HasFactory;

    protected $table = 'mtransaksi';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'nama',
        'jenis',
    ];
}
