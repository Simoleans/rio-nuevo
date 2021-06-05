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


    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function maquina(){
        return Machine::where('nombre',$this->maquina)->first();
    }

    // public function horasDelta(){

    //     $afterReport = Reporte::orderBy('id', 'desc')->where('id','!=',$this->id)->first();
    //     dd($afterReport);
    // }
}
