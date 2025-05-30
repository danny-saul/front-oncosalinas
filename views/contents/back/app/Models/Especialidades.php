<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
    use HasFactory;

    protected $table = "especialidades";
    protected $filleable = ['nombre_especialidad', 'estado'];
    public $timestamps = false;

    public function doctor_especialidades(){
        return $this->hasMany(Doctor_Especialidades::class);
    }
    
    public function doctor(){
        return $this->HasMany(Doctor::class);
    }
}
