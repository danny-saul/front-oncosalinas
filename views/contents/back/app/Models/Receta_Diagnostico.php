<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta_Diagnostico extends Model
{
    use HasFactory;

    protected $table = "receta_diagnostico";
    protected $filleable = ['citas_id','receta_id','diagnosticocie10_id','tipo_diagnostico_id','estado'];
    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }


    public function receta(){
        return $this->belongsTo(Receta::class);
    }

    public function diagnosticocie10(){
        return $this->belongsTo(Diagnosticocie10::class);
    }


    public function tipo_diagnostico() {
        return $this->belongsTo(Tipo_Diagnostico::class);
    } 

}
