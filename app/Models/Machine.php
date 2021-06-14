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

    public function temporada()
    {
        return $this->belongsTo(Temporada::class,)->withDefault(['nombre' => 'N/T']);
    }

    public function scopeActive($query){
        
        return $query->where('status',1);
    }

}
