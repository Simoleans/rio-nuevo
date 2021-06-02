<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'rut',
            'razon_social',
            'localidad',
            'region',
            'comuna',
            'direccion',
            'nombre_responsable',
            'email',
            'telefono',
            'status'
    ];
}
