<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    use HasFactory;

    protected $table = "detalle_venta";
    protected $fillable = ['ventas_id','productos_id','cantidad', 'precio_venta', 'total_general',  'es_orden'];
    public $timestamps = false;

    public function ventas()
    {
        return $this->belongsTo(Ventas::class);
    }
 

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
