<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiares_Antecedentes extends Model
{
    use HasFactory;
    protected $table = "familiares_antecedentes";
    protected $filleable = ['paciente_id', 'antecedentesfamiliares_id','grupos_antecedentes_familiares_id', 'observacion', 'fecha', 'estado'];

    public $timestamps = false;

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function antecedentesfamiliares(){
        return $this->belongsTo(Antecedentesfamiliares::class);
    }

    public function grupos_antecedentes_familiares(){
        return $this->belongsTo(Grupos_Antecedentes_Familiares::class);
    }

}
