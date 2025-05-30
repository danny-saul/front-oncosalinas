<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Model  implements JWTSubject
{
    use HasFactory;


    protected $table = "usuario";
    protected $filleable = ['persona_id', 'roles_id', 'usuario', 'correo', 'password', 'password2', 'imagen', 'imagen_cedula', 'estado'];
    public $timestamps = false;


    public function roles(){
        return $this->belongsTo(Rol::class);
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function ventas(){
        return $this->hasMany(Ventas::class);
    }
  
}
