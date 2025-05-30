<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedad_Periodontal extends Model
{
    use HasFactory;

    protected $table = "enfermedad_periodontal";
    protected $filleable = ['enfermedad_dientes_id','paciente_id','respuesta','estado'];
    public $timestamps = false;

    public function enfermedad_dientes(){
        return $this->belongsTo(Enfermedad_Dientes::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
