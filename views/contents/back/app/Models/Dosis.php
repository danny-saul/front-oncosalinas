<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosis extends Model
{
    use HasFactory;
    protected $table = "dosis";
    protected $filleable = ['tipo_dosis','estado'];

    public $timestamps = false;


    public function receta(){
        return $this->hasMany(Receta::class);
    }

       public function receta_detalle(){
        return $this->hasMany(Receta_Detalle::class);
    }

}
