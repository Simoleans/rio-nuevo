<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'nombre',
            'temporada_id',
            'status',
    ];

    public function users()
    {
        return $this->hasOne(User::class,);
    }

    public function reportes(){
        return $this->hasMany(Reporte::class,'maquina_id');
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class,)->withDefault(['nombre' => 'N/T']);
    }

    public function machineToReportDay($fecha)
    {
        $data = '';
        foreach($this->reportes()->where('fecha',$fecha)->get() as $r){
            $data  .= $r->kg_totales === NULL ? '0' : $r->kg_totales.' Kg <br>';
        }

        return $data;
    }

    public function reportesCountToWeek($fecha)
    {
        return $this->reportes()->where('fecha',$fecha)->count();
    }

    public function scopeActive($query){
        
        return $query->where('status',1);
    }

}
