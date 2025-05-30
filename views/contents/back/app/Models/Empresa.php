<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = "empresa";
    protected $filleable = ['ruc', 'nombre_empresa','direccion_empresa','barra2','telefono1_empresa','telefono2_empresa', 'correo','logo'];
    public $timestamps = false;
    
}
