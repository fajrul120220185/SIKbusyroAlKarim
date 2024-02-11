<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTranSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'mtrans_siswa';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'kelas_id',
        'kelas',
        'jumlah',
        'done',
        'created_at',
        'end_date',
        'siswa_id',
    ];

    public function transSiswa()
    {
        return $this->hasMany(TransaksiSiswa::class, 'trans_id', 'id');
    }
}
