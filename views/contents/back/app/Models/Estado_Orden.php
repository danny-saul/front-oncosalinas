<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_Orden extends Model
{
    use HasFactory;
    protected $table = "estado_orden";
    public $timestamps = false;


    
    public function ordenes(){
        return $this->hasMany(orden::class);
    }

    public function laboratorio(){
        return $this->hasMany(Laboratorio::class);
    }

}
