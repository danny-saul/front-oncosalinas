<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimiento_Odonto extends Model
{
    use HasFactory;
    protected $table = "procedimiento_odonto";
    protected $filleable = ['clave_pro','descripcion_pro','estado'];
    public $timestamps = false;

    public function odontograma_detalle(){
        return $this->belongsTo(Odontograma_Detalle::class);
    }
}
