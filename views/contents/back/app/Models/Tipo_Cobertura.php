<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Cobertura extends Model
{
    use HasFactory;
    protected $table = "tipo_cobertura";
    protected $filleable = ['detalle_tipo_cobertura','estado'];
    public $timestamps = false;

    public function persona(){
        return $this->hasMany(Persona::class);
    }
}
