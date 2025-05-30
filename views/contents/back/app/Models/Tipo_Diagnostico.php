<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tipo_Diagnostico extends Model
{
    use HasFactory;
    protected $table = "tipo_diagnostico";
    public $timestamps = false;

    public function receta_diagnostico(){
        return $this->HasMany(Receta_Diagnostico::class);
    }

    public function odontograma_diagnostico(){
        return $this->hasMany(Odontograma_Diagnostico::class);
    }

}
