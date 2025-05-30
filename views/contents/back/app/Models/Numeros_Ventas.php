<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeros_Ventas extends Model
{
    use HasFactory;
    protected $table = "numeros_ventas";
    protected $filleable = ['num_venta', 'id_tablas', 'estado'];
    public $timestamps = false;
}
