<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedad_Dientes extends Model
{
    use HasFactory;
    protected $table = "enfermedad_dientes";
    protected $filleable = ['tipo','estado'];
    public $timestamps = false;

    public function enfermedad_periodontal(){
        return $this->hasMany(Enfermedad_Periodontal::class);
    }

    public function paciente_fluorosis(){
        return $this->hasMany(Paciente_Fluorosis::class);
    }
}
