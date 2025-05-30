<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    use HasFactory;

    protected $table = "laboratorio";
    protected $filleable = ['doctor_id', 'citas_id', 'paciente_id', 'numero_orden_lab','estado_orden_id','documento_lab','informe_lab','conclusion_lab','subtotal','descuento','iva' ,'total','estado'];	

    public $timestamps = false;


    public function paciente(){
        return $this->belongsTo(Paciente::class);
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

    public function laboratorio_detalle(){
        return $this->hasMany(Laboratorio_Detalle::class);
    }
}
