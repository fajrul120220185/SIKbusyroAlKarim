<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;
    protected $table = 'saving';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'jumlah',
        'sumber',
        'user',
        'bulan',
        'tahun',
    ];
}
