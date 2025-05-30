<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piezas_Higiene extends Model
{
    use HasFactory;
    protected $table = "piezas_higiene";
    protected $filleable = ['num_pieza','estado'];
    public $timestamps = false;

    public function piezas_paciente_higiene(){
        return $this->hasMany(Piezas_Paciente_Higiene::class);
    }
}
