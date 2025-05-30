<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;
    protected $table = "servicios";
    protected $filleable = ['detalle_servicio','precio','estado'];
    public $timestamps = false;

  public function citas_servicios(){
        return $this->hasMany(Citas_Servicios::class);
    }
}
