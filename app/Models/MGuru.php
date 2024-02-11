<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MGuru extends Model
{
    use HasFactory;
    protected $table = 'mguru';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'no_hp',
        'gaji',
    ];
}
