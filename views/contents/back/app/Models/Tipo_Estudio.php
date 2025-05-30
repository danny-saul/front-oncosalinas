<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Estudio extends Model
{
    use HasFactory;
    protected $table = "tipo_estudio";
    protected $filleable = ['codigo', 'descripcion', 'urvi','urvii','urviiii','estado'];
    public $timestamps = false;

    public function orden(){
        return $this->hasMany(Orden::class);
    }
 
}
