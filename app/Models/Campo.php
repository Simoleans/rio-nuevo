<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','localidad','productor_id'];

    public function scopeProductores($query,$productor){
        
        return $query->where('productor_id',$productor);
    }
}
