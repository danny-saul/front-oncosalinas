<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Seguro extends Model
{
    use HasFactory;

    protected $table = "tipo_seguro";
    protected $filleable = ['detalle_seguro','estado'];
    public $timestamps = false;

    public function persona(){
        return $this->hasMany(Persona::class);
    }
}
