<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    
    protected $table = "cliente";
    protected $filleable = ['persona_id','estado'];
    public $timestamps = false;

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

 
}
