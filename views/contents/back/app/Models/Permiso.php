<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = "permisos";
    protected $filleable = ['rol_id', 'menu_id', 'acceso', 'estado'];
    public $timestamps = false;

    public function menu(){
        return $this->belongsTo(Menu::class);
    }
}
