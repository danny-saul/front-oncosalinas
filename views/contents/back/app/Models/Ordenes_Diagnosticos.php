<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenes_Diagnosticos extends Model
{
    use HasFactory;
    protected $table = "ordenes_diagnosticos";
    protected $filleable = ['ordenes_id','diagnosticocie10_id','estado'];
    public $timestamps = false;

    public function Orden(){
        return $this->belongsTo(Orden::class);
    }


    public function diagnosticocie10(){
        return $this->belongsTo(Diagnosticocie10::class);
    }



}
