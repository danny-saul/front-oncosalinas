<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aislamiento extends Model
{
    use HasFactory;
    protected $table = "aislamiento";
    protected $filleable = ['tipo_aislamiento','estado'];
    public $timestamps = false;

    public function certificados_medicos(){
        return $this->hasMany(Certificados_Medicos::class);
    }
}
