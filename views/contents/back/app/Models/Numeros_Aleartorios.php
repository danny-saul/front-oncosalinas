<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeros_Aleartorios extends Model
{
    use HasFactory;
    protected $table = "numeros_aleartorios";
    protected $filleable = ['numeros', 'id_tablas', 'estado'];
    public $timestamps = false;

}
