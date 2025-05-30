<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico_Odonto extends Model
{
    use HasFactory;

    protected $table = "diagnostico_odonto";
    protected $filleable = ['clave_od','descripcion_od','estado'];
    public $timestamps = false;


    public function odontograma_detalle(){
        return $this->belongsTo(Odontograma_Detalle::class);
    }

    public function odontograma_diagnostico(){
        return $this->hasMany(Odontograma_Diagnostico::class);
    }
}
