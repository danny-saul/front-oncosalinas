<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;

    protected $table = "dias";
    protected $filleable = ['dia', 'estado', 'orden'];
    public $timestamps = false;

    
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

}
