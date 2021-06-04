<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'productor',
            'campo',
            'maquina',
            'tipo_cultivo',
            'variedad',
            'hs_maquina',
            'cuartel',
            'tipo_bandeja',
            'nro_bandeja',
            'kg_totales',
            'kg_teoricos',
            'petroleo',
            'hectareas',
            'observacion',
            'status'
    ];
}
