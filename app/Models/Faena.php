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
        'user_finalizar',
        'status',
        'user_id',
        'temporada'
    ];

    public function scopeProceso($query){
        return $query->where('status',1);
    }
}
