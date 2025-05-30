<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = "persona";
    protected $filleable = ['cedula', 'nombre', 'apellido', 'telefono','celular','operadora_id', 'direccion','fecha_nacimiento','tipo_seguro_id', 'sexo_id','tipo_cobertura_id','responsable', 'estado'];
    public $timestamps = false;

    public function usuario(){
        return $this->HasMany(Usuario::class);
    }

    public function sexo(){
        return $this->belongsTo(Sexo::class);
    }

    public function doctor(){
        return $this->HasMany(Doctor::class);
    }

    public function paciente(){
        return $this->HasMany(Paciente::class);
    } 
     public function operadora(){
        return $this->belongsTo(Operadora::class);
    }
    public function tipo_cobertura(){
        return $this->belongsTo(Tipo_Cobertura::class);
    }

    public function tipo_seguro(){
        return $this->belongsTo(Tipo_Seguro::class);
    }
}
