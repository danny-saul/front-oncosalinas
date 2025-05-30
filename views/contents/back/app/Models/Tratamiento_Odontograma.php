<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento_Odontograma extends Model
{
    use HasFactory;
    protected $table = "tratamiento_odontograma";
    protected $filleable = ['nombre_tratamiento', 'estado'];
    public $timestamps = false;


    public function odontograma(){
        return $this->hasMany(Odontograma::class);
    }
    public function odontograma_detalle(){
        return $this->belongsTo(Odontograma_Detalle::class);
    }

    public function odonto_componentedetalle(){
        return $this->hasMany(Odonto_Componentedetalle::class);
    }
}
