<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $table = "receta";
    protected $filleable = ['numero_receta','citas_id','paciente_id','status_facturado','fecha_rece','estado'];
    public $timestamps = false;


    
    public function receta_diagnostico(){
        return $this->hasMany(Receta_Diagnostico::class);
    }

       
    public function citas(){
        return $this->belongsTo(Citas::class);
    }

       public function paciente(){
        return $this->belongsTo(Paciente::class);
    }


    public function receta_detalle(){
        return $this->hasMany(Receta_Detalle::class);
    }

  

}
