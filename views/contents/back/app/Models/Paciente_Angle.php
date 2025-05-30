<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente_Angle extends Model
{
    use HasFactory;
    
    protected $table = "paciente_angle";
    protected $filleable = ['paciente_id','angle_id','respuesta','estado'];
    public $timestamps = false;

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function angle(){
        return $this->belongsTo(Angle::class);
    }
}
