<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente_Fluorosis extends Model
{
    use HasFactory;
    protected $table = "paciente_fluorosis";
    protected $filleable = ['paciente_id','enfermedad_dientes_id','respuesta','estado'];
    public $timestamps = false;

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function enfermedad_dientes(){
        return $this->belongsTo(Enfermedad_Dientes::class);
    }
}
