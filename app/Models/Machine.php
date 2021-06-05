<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    public $primaryKey = 'nombre';

    protected $fillable = [
            'user_id',
            'nombre',
            'marca',
            'modelo',
            'tipo',
            'year',
            'serie',
            'status',
    ];

    

    public function users()
    {
        return $this->hasOne(User::class,);
    }

    // public function setUserIdAttribute($value)
    // {
    //     $this->attributes['user_id'] = auth()->user()->id;
    // }
}
