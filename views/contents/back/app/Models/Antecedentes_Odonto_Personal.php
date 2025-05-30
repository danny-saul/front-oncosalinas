<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentes_Odonto_Personal extends Model
{
 
    use HasFactory;
    protected $table = "antecedentes_odonto_personal";
    protected $fillable = ['paciente_id','odonto_antecedentes_per_id ', 'respuesta','fecha','estado'];
    public $timestamps = false;

    // En el modelo Antecedentes_Odonto_Personal
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function odonto_antecedentes_per()
    {
        return $this->belongsTo(Odonto_Antecedentes_Per::class);
    }

    // En el modelo Antecedentes_Odonto_Personal

     


}
				 
