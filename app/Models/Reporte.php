<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'productor_id',
            'campo_id',
            'maquina_id',
            'h_anterior',
            'tipo_cultivo_id',
            'variedad_id',
            'hs_maquina',
            'tipo_bandeja',
            'nro_bandeja',
            'kg_totales',
            'kg_teoricos',
            'observacion',
            'status',
            'user_anular',
            'horas_delta',
            'fecha'
    ];


    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function scopeMaquinaByUser($query,$maquina){

        return $query->where('maquina_id',$maquina)->where('user_id',auth()->user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function maquina(){
        return $this->belongsTo(Machine::class,'maquina_id')->withDefault(['nombre' => 'N/T']);
    }

    public function productor(){
        return $this->belongsTo(Productor::class,'productor_id')->withDefault(['razon_social' => 'N/T']);
    }

    public function campo(){
        return $this->belongsTo(Campo::class,'campo_id')->withDefault(['nombre' => 'N/T']);
    }

    public function tipo_cultivo(){
        return $this->belongsTo(TipoCultivo::class,'tipo_cultivo_id')->withDefault(['nombre' => 'N/T']);
    }

    public function variedad(){
        return $this->belongsTo(Variedad::class,'variedad_id')->withDefault(['nombre' => 'N/T']);
    }

    public function userAnular()
    {
        return $this->belongsTo(User::class,'user_anular')->withDefault(['name' => 'N/T']);
    }

    // public function maquina(){
    //     return Machine::where('nombre',$this->maquina)->first();
    // }

    public function concatenadoLiquidacion()
    {
        return  $this->productor.'-'.$this->maquina.'-'.$this->created_at->format('d-m-Y').'-'.$this->campo;
    }

}
