<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta_Detalle extends Model
{
    use HasFactory;

    protected $table = "receta_detalle";
    protected $filleable = ['receta_id','producto_id','cantidad','dosis_id','frecuencia_id','via_id','duracion','observacion','status_facturado','fecha','estado'];
    public $timestamps = false;


    
    public function receta(){
        return $this->belongsTo(Receta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function dosis(){
        return $this->belongsTo(Dosis::class);
    }

       public function via(){
        return $this->belongsTo(Via::class);
    }

    public function frecuencia(){
        return $this->belongsTo(Frecuencia::class);
    }

}
