<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedentes_Estomatognatico_Paciente extends Model
{
    use HasFactory;
    protected $table = "antecedentes_estomatognatico_paciente";
    protected $fillable = ['paciente_id','odonto_estomatognatico_id ', 'respuesta','fecha','estado'];
    public $timestamps = false;



    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function odonto_estomatognatico()
    {
        return $this->belongsTo(Odonto_Estomatognatico::class);
    }



}
