<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
    use HasFactory;
    protected $table = "presentacion";
    protected $filleable = ['tipo_presentacion','estado'];
    public $timestamps = false;

    public function producto(){
        return $this->hasMany(Producto::class);
    }
}
