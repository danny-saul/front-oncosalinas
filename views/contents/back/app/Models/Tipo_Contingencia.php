<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Contingencia extends Model
{
    use HasFactory;
    protected $table = "tipo_contingencia";
    protected $filleable = ['contingencia','estado'];
    public $timestamps = false;

    public function certificados_medicos(){
        return $this->hasMany(Certificados_Medicos::class);
    }
}
