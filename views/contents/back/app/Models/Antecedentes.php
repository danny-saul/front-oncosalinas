<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentes extends Model
{
    use HasFactory;
    protected $table = "antecedentes";
    protected $filleable = ['grupos_antecedentes_id','nombre_antecedente','estado'];
    public $timestamps = false;

    public function grupos_antecedentes(){
        return $this->belongsTo(Grupos_Antecedentes::class);
    }

    public function paciente_antecedentes(){
        return $this->hasMany(Paciente_Antecedentes::class);
    }


}


 	
