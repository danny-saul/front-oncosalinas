<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas_Servicios extends Model
{
    use HasFactory;
        protected $table = "citas_servicios";
    protected $filleable = ['citas_id','servicios_id','estado'];
    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function servicios(){
        return $this->belongsTo(Servicios::class);
    }
}
