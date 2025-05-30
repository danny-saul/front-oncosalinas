<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correos_Recibidos extends Model
{
    use HasFactory;

    protected $table = "correos_recibidos";
    public $timestamps = false;

}
