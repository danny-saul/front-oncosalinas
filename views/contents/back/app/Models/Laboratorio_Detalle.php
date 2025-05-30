<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio_Detalle extends Model
{
    use HasFactory;
   
    protected $table = "laboratorio_detalle";
    protected $filleable = ['laboratorio_id', 'tipo_examen_id', 'resultado_examen', 'justificacion_lab','resumen_lab','cantidad','precio_venta','total_general'];	

    public $timestamps = false;


    public function tipo_examen(){
        return $this->belongsTo(Tipo_Examen::class);
    }
    public function laboratorio(){
        return $this->belongsTo(Laboratorio::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function estado_orden(){
        return $this->belongsTo(Estado_Orden::class);
    }
}
