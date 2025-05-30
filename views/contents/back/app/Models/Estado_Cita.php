<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_Cita extends Model
{
    use HasFactory;
    
     protected $table = "estado_cita";
    protected $filleable = ['detalle', 'estado'];

    public $timestamps = false;


    public function citas(){
        return $this->hasMany(Citas::class);
    }
}
