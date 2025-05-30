<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Examen extends Model
{
    use HasFactory;

    protected $table = "tipo_examen";
    protected $filleable = ['categoria_laboratorio_id ','codigo_lab', 'descripcion_lab', 'urvi_lab','urvii_lab','urviiii_lab','estado'];
    public $timestamps = false;

    public function categoria_laboratorio(){
        return $this->belongsTo(Categoria_Laboratorio::class);
    }

    public function laboratorio_detalle(){
        return $this->hasMany(Laboratorio_Detalle::class);
    }
}
