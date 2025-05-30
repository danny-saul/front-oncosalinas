<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odonto_Componentedetalle extends Model
{
    use HasFactory;
   
    protected $table = "odonto_componentedetalle";
    protected $fillable = [
        'odontograma_id',
        'pieza',
        'doctor_id',
        'citas_id',
        'tratamiento_odontograma_id',
        'elementoComponente',
        'estadoCarilla',
        'numeroDiente',
        'estado_activo',
        'fecha',
        'fecha_creacion',
        'fecha_modificacion',
        
    ];
    
    public $timestamps = false;
    		
    public function odontograma(){
        return $this->belongsTo(Odontograma::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function Citas(){
        return $this->belongsTo(Citas::class);
    }

    public function tratamiento_odontograma(){
        return $this->belongsTo(Tratamiento_Odontograma::class);
    }
}
