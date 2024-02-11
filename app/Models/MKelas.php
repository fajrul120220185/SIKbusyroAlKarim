<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKelas extends Model
{
    use HasFactory;

    protected $table = 'mkelas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'kelas',
        'grade',
        'guru_id',
        'walikelas',
        'tarif_spp'
    ];

   
}
