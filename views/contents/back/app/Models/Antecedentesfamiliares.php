<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentesfamiliares extends Model
{
    use HasFactory;
    protected $table = "antecedentesfamiliares";
    protected $filleable = ['grupos_antecedentes_familiares_id','nombre_antecedente','estado'];
    public $timestamps = false;

    public function grupos_antecedentes_familiares(){
        return $this->belongsTo(Grupos_Antecedentes_Familiares::class);
    }

    public function familiares_antecedentes(){
        return $this->hasMany(Familiares_Antecedentes::class);
    }

}
