<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = "doctor";
    protected $filleable = ['persona_id', 'especialidades_id', 'img_sello', 'reg_senescyt','reg_access', 'estado'];
    public $timestamps = false;

    public function persona(){
        return $this->belongsTo(Persona::class);
    }
    public function especialidades(){
        return $this->belongsTo(Especialidades::class);
    }
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

    public function citas(){
        return $this->hasMany(Citas::class);
    }

    public function ordenes(){
        return $this->hasMany(orden::class);
    }
    public function doctor_especialidades(){
        return $this->hasMany(Doctor_Especialidades::class);
    }

    public function laboratorio(){
        return $this->hasMany(Laboratorio::class);
    }

    public function odonto_componentedetalle(){
        return $this->hasMany(Odonto_Componentedetalle::class);
    }

  
}
