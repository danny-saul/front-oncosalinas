<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados_Medicos extends Model
{
    use HasFactory;
    protected $table = "certificados_medicos";
    protected $filleable = ['citas_id', 'dia_descanso', 'actividad_laboral', 'entidad_laboral','direccion','aislamiento_id','tipo_contingencia_id','observacion', 'estado'];
    								

    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function aislamiento(){
        return $this->belongsTo(Aislamiento::class);
    }

    public function tipo_contingencia(){
        return $this->belongsTo(Tipo_Contingencia::class);
    }
}
