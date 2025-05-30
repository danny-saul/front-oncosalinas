<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    protected $table = "ordenes";
    protected $filleable = ['doctor_id', 'citas_id', 'tipo_estudio_id', 'numero_orden', 'lateralidad_id','justificacion','resumen','estado_orden_id','documento','informe','conclusion', 'estado'];

    public $timestamps = false;


    public function tipo_estudio(){
        return $this->belongsTo(Tipo_Estudio::class);
    }
    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function estado_orden(){
        return $this->belongsTo(Estado_Orden::class);
    }

    public function ordenes_diagnostico(){
        return $this->hasMany(Ordenes_Diagnosticos::class, 'ordenes_id');
    }


    

}
