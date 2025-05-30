<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes_Ventas extends Model
{
    use HasFactory;

    protected $table = "ordenes_ventas";
    protected $filleable = ['citas_id','ventas_id','estado'];
    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function ventas(){
        return $this->belongsTo(Ventas::class);
    }
}
