<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanaBos extends Model
{
    use HasFactory;
    protected $table = 'dana_bos';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'jumlah',
        'user',
        'bulan',
        'tahun',
    ];
}
