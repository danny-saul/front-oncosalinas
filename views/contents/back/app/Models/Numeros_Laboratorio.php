<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeros_Laboratorio extends Model
{
    use HasFactory;
    protected $table = "numeros_laboratorio";
    protected $filleable = ['num_labs', 'id_tablas2', 'estado'];
    public $timestamps = false;
}
