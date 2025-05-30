<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $filleable = ['num_venta','usuario_id', 'paciente_id',  'subtotal', 'descuento', 'iva', 'total', 'fecha','descripcion1','descripcion2', 'estado'];
    public $timestamps = false;


    public function detalle_venta(){
        return $this->hasMany(Detalle_Venta::class);
    }

    public function ordenes_ventas(){
        return $this->hasMany(Ordenes_Ventas::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
