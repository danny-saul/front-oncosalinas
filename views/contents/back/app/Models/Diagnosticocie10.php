<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosticocie10 extends Model
{
    use HasFactory;
    protected $table = "diagnosticoscie10";
    protected $filleable = ['clave','descripcion','idCategoria','estado'];
    public $timestamps = false;

        
    public function receta_diagnostico(){
        return $this->hasMany(Receta_Diagnostico::class);
    }

    public function ordenes_diagnostico(){
        return $this->hasMany(Ordenes_Diagnosticos::class);
    }


}
