<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odonto_Estomatognatico extends Model
{
    use HasFactory;
    protected $table = "odonto_estomatognatico";
    protected $fillable = ['tipo_estomato', 'estado'];
    public $timestamps = false;

    public function antecedentes_estomatognatico_paciente()
    {
        return $this->hasMany(Antecedentes_Estomatognatico_Paciente::class);
    }
    
}
