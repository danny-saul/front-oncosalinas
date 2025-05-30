<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen_Fisica extends Model
{
    use HasFactory;
    protected $table = "examen_fisica";
    protected $filleable = ['citas_id', 'temperatura','peso', 'talla','presion_arterial', 'imc', 'pulso', 'frecuencia_respiratoria', 'observacion_examen','recomendacion','saturacion_oxigeno', 'fecha', 'estado'];

    public $timestamps = false;

    public function citas(){
       return $this->belongsTo(Citas::class);

    }

}
 