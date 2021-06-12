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
            'temporada',
            'status',
    ];

    public function users()
    {
        return $this->hasOne(User::class,);
    }

    public function scopeActive($query){
        
        return $query->where('status',1);
    }

}
