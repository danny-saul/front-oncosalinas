<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma_Diagnostico extends Model
{
    use HasFactory;
    protected $table = "odontograma_diagnostico";
    protected $filleable = ['diagnostico_odonto_id', 'tipo_diagnostico_id', 'odontograma_id','paciente_id','estado'];
    public $timestamps = false;

    public function diagnostico_odonto(){
        return $this->belongsTo(Diagnostico_Odonto::class);
    }
    public function tipo_diagnostico(){
        return $this->belongsTo(Tipo_Diagnostico::class);
    }
    public function odontograma(){
        return $this->belongsTo(Odontograma::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
    		
}
