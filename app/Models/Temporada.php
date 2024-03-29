<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'pais',
        'fecha_fin',
        'fecha_inicio',
        'user_finalizar'
    ];

    public function scopeActive($query){
        return $query->where('status',1);
    }
}
