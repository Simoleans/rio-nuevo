<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faena extends Model
{
    use HasFactory;

    protected $fillable = [
        'productor',
        'campo',
        'maquina',
        'fecha_inicio',
        'fecha_final',
        'status',
        'user_id'
    ];

    public function scopeProceso($query){
        return $query->where('status',1);
    }
}
