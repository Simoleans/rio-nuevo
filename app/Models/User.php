<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function machines()
    {
        return $this->hasMany(Machine::class,);
    }

    public function productors()
    {
        return $this->hasMany(Productor::class,);
    }

    public function reportes(){
        return $this->hasMany(Reporte::class);
    }

    public function reportesTotal(){
        return $this->reportes()->count();
    }

    public function isAdmin(){

        return $this->rol == 'admin';
    }

    public function isOperador(){

        return $this->rol == 'operador';
    }

    public function reportesCountToWeek($fecha)
    {
        return $this->reportes()->where('fecha',$fecha)->count();
    }

    public function machineToReportDay($fecha)
    {
        $data = [];
        foreach($this->reportes()->where('fecha',$fecha)->get() as $r){
            $data [] = $r->maquina->nombre.' | '.$r->kg_totales.' Kg';
        }

        return $data;
    }

    public function scopeActive($query){

        return $query->where('status',1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeInactive($query){
        
        return $query->where('status',0);
    }

    public function scopeOperadoresActivos($query){
        return $query->where('rol','operador')->active();
    }
}
