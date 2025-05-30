<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = "paciente";
    protected $filleable = ['persona_id','estado'];
    public $timestamps = false;

    public function persona(){
        return $this->belongsTo(Persona::class);
    }
      public function citas(){
        return $this->hasMany(Citas::class);
    }

    public function paciente_antecedentes(){
        return $this->hasMany(Paciente_Antecedentes::class);
    }

    public function familiares_antecedentes(){
        return $this->hasMany(Familiares_Antecedentes::class);
    }

    public function odontograma(){
        return $this->hasMany(Odontograma::class);
    }

    public function ventas(){
        return $this->hasMany(Ventas::class);
    }
    public function laboratorio(){
        return $this->hasMany(Laboratorio::class);
    }


    public function antecedentes_odonto_personal()
    {
        return $this->hasMany(Antecedentes_Odonto_Personal::class);
    }

    public function antecedentes_odonto_familiar()
    {
        return $this->hasMany(Antecedentes_Odonto_Familiar::class);
    }

    public function antecedentes_estomatognatico_paciente()
    {
        return $this->hasMany(Antecedentes_Estomatognatico_Paciente::class);
    }

    public function piezas_paciente_higiene(){
        return $this->hasMany(Piezas_Paciente_Higiene::class);
    }

    public function enfermedad_periodontal(){
        return $this->hasMany(Enfermedad_Periodontal::class);
    }

    public function paciente_angle(){
        return $this->hasMany(Paciente_Angle::class);
    }

    public function paciente_fluorosis(){
        return $this->hasMany(Paciente_Fluorosis::class);
    }
    
    public function odontograma_diagnostico(){
        return $this->hasMany(Odontograma_Diagnostico::class);
    }
      public function receta(){
        return $this->hasMany(Receta::class);
    }
}
