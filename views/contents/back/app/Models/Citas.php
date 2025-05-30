<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    
    protected $table = "citas";
    protected $filleable = ['codigo_cita','paciente_id','doctor_id','doctor_horario_id','fecha','estado_cita_id','libre','total','estado','created_at'.'updated_at'];
  //  public $timestamps = false;

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }


    public function estado_cita(){
        return $this->belongsTo(Estado_Cita::class);
    }

 
    public function doctor_horario(){
        return $this->belongsTo(Doctor_Horario::class);
    }
     public function citas_servicios(){
        return $this->hasMany(Citas_Servicios::class);
    }

    public function ordenes(){
        return $this->hasMany(Orden::class);
    }

    public function receta(){
        return $this->hasMany(Receta::class);
    }

    public function historial_clinico(){
        return $this->hasMany(Historial_Clinico::class);
    }

    public function receta_diagnostico(){
        return $this->hasMany(Receta_Diagnostico::class);
    }

    public function certificados_medicos(){
        return $this->hasMany(Certificados_Medicos::class);
    }
    
    public function laboratorio(){
        return $this->hasMany(Laboratorio::class);
    }

    public function examen_fisica(){
        return $this->hasMany(Examen_Fisica::class);
    }

    public function ordenes_ventas(){
        return $this->hasMany(Ordenes_Ventas::class);
    }

    public function odonto_componentedetalle(){
        return $this->hasMany(Odonto_Componentedetalle::class);
    }
 

}
