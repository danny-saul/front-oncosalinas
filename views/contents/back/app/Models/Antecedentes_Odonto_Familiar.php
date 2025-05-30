<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentes_Odonto_Familiar extends Model
{
    use HasFactory;
    protected $table = "antecedentes_odonto_familiar";
    protected $fillable = ['paciente_id','odonto_antecedentes_fam_id ', 'respuesta','fecha','estado'];
    public $timestamps = false;


    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function odonto_antecedentes_fam()
    {
        return $this->belongsTo(Odonto_Antecedentes_Fam::class);
    }


}
