<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odonto_Antecedentes_Per extends Model
{
    use HasFactory;
    protected $table = "odonto_antecedentes_per";
    protected $fillable = ['tipo_antecedente_per', 'estado'];
    public $timestamps = false;


    
    public function antecedentes_odonto_personal()
    {
        return $this->hasMany(Antecedentes_Odonto_Personal::class);
    }

}
