<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piezas_Paciente_Higiene extends Model
{
    use HasFactory;

    protected $table = "piezas_paciente_higiene";
    protected $filleable = ['piezaz_higiene_id','paciente_id','respuesta','estado'];
    public $timestamps = false;

    public function piezas_higiene(){
        return $this->belongsTo(Piezas_Higiene::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
