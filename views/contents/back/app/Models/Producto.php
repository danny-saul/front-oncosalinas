<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = "producto";
    protected $filleable = ['categoria_id','codigo','nombre_producto','nombre_comercial','descripcion','presentacion_id','imagen','stock','marca','precio_venta','precio_compra','fecha','estado'];
    public $timestamps = false;

    public function categoria(){
        return $this->belongsTo(Categoria::class);

    }

    public function presentacion(){
        return $this->belongsTo(Presentacion::class);

    }

    public function receta(){
        return $this->hasMany(Receta::class);
    }

    public function detalle_venta(){
        return $this->hasMany(Detalle_Venta::class);
    }

    public function receta_detalle(){
        return $this->hasMany(Receta_Detalle::class);
    }

}
