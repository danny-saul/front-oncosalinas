<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    use HasFactory;
    protected $table = "odontograma";
    protected $filleable = ['paciente_id', 'doctor_id', 'citas_id','fecha_creacion','fecha_modificacion'];
    public $timestamps = false;
    		

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function odontograma_detalle(){
        return $this->hasMany(Odontograma_Detalle::class);
    }

    public function odonto_componentedetalle(){
        return $this->hasMany(Odonto_Componentedetalle::class);
    }
    public function odontograma_diagnostico(){
        return $this->hasMany(Odontograma_Diagnostico::class);
    }
    
}
