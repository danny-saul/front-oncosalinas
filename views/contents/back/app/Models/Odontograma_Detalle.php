<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma_Detalle extends Model
{
    use HasFactory;

    protected $table = "odontograma_detalle";
    protected $fillable = [
        'odontograma_id',
        'pieza',
        'cuadrante',
        'citas_id',
        'tratamiento_odontograma_id',
        'diagnostico_odonto_id',
        'procedimiento_odonto_id',
        'estado_activo',
        'fecha',
        'fecha_creacion',
        'fecha_modificacion',
        'estado', // Asegúrate de que "estado" está aquí
    ];
    
    public $timestamps = false;
    		
    public function odontograma(){
        return $this->belongsTo(Odontograma::class);
    }

    public function tratamiento_odontograma(){
        return $this->belongsTo(Tratamiento_Odontograma::class);
    }

    public function diagnostico_odonto(){
        return $this->belongsTo(Diagnostico_Odonto::class);
    }
    public function procedimiento_odonto(){
        return $this->belongsTo(Procedimiento_Odonto::class);
    }

}
