<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_Laboratorio extends Model
{
    use HasFactory;

    protected $table = "categoria_laboratorio";
    protected $filleable = ['descripcion_categoria','estado'];
    public $timestamps = false;
    

    public function tipo_examen(){
        return $this->hasMany(Tipo_Examen::class);
    }
}
