<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Clinico extends Model
{
    use HasFactory;
        
    protected $table = "historial_clinico";
    protected $filleable = ['codigo_h','citas_id','motivo_consulta','antecedentes','enfermedad_actual','evolucion','alergias','fecha','estado'];
    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }
}
