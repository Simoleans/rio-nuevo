<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variedad extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_cultivo_id','nombre'];

    public function scopeCultivo($query,$id){
        return $query->where('tipo_cultivo_id',$id);
    }

    public function tipo_cultivo(){
        return $this->belongsTo(TipoCultivo::class)->withDefault(['nombre' => 'N/T']);
    }
}
