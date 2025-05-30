<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frecuencia extends Model
{
    use HasFactory;
    protected $table = "frecuencia";
    public $timestamps = false;

    public function receta(){
        return $this->hasMany(Receta::class);
    }

       public function receta_detalle(){
        return $this->hasMany(Receta_Detalle::class);
    }

}
