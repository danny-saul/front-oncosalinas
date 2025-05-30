<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odonto_Antecedentes_Fam extends Model
{
    use HasFactory;
    protected $table = "odonto_antecedentes_fam";
    protected $fillable = ['tipo_antecedente_fam', 'estado'];
    public $timestamps = false;

 
    public function antecedentes_odonto_familiar()
    {
        return $this->hasMany(Antecedentes_Odonto_Familiar::class);
    }
}
