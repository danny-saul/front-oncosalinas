<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_Horario extends Model
{
    use HasFactory;
  

    protected $table = "doctor_horario";
    protected $filleable = ['doctor_id', 'usuario_id', 'dia_id', 'hora_inicio', 'hora_fin','status', 'estado'];
    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function citas(){
        return $this->hasMany(Citas::class);
    }

    public function dia(){
        return $this->belongsTo(Dia::class);
    }
}
