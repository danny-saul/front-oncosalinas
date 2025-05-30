<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos_Antecedentes_Familiares extends Model
{
    use HasFactory;
    protected $table = "grupos_antecedentes_familiares";
    protected $filleable = ['nombre','estado'];
    public $timestamps = false;


    public function antecedentesfamiliares(){
        return $this->hasMany(Antecedentesfamiliares::class,'grupos_antecedentes_familiares_id');
    }

    public function familiares_antecedentes(){
        return $this->hasMany(Familiares_Antecedentes::class);
    }
}
