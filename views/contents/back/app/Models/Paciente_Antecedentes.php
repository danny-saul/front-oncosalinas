<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente_Antecedentes extends Model
{
    use HasFactory;
    protected $table = "paciente_antecedentes";
    protected $filleable = ['paciente_id', 'antecedentes_id','grupos_antecedentes_id', 'observacion', 'fecha', 'estado'];

    public $timestamps = false;

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function antecedentes(){
        return $this->belongsTo(Antecedentes::class);
    }


}
