<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeros_Receta extends Model
{
    use HasFactory;
    protected $table = "numeros_receta";
    protected $filleable = ['num_receta', 'id_tablas4', 'estado'];
    public $timestamps = false;
}
