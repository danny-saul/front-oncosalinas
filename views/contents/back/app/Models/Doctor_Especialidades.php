<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_Especialidades extends Model
{
    use HasFactory;
    protected $table = "doctor_especialidades";
    protected $filleable = ['doctor_id', 'especialidades_id', 'estado'];
    public $timestamps = false;

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function especialidades(){
        return $this->belongsTo(Especialidades::class);
    }

}
