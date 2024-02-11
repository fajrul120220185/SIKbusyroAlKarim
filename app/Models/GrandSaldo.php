<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrandSaldo extends Model
{
    use HasFactory;

    protected $table = 'grand_saldo';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'saldo',
    ];
}
