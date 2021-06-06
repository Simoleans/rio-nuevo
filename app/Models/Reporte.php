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
            'status',
            'user_anular',
            'horas_delta',
            'fecha'
    ];


    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userAnular()
    {
        return $this->belongsTo(User::class,'user_anular')->withDefault(['name' => 'N/T']);
    }

    public function maquina(){
        return Machine::where('nombre',$this->maquina)->first();
    }

    public function concatenadoLiquidacion()
    {
        return  $this->productor.'-'.$this->maquina.'-'.$this->created_at->format('d-m-Y').'-'.$this->campo;
    }

}
