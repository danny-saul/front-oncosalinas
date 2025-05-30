<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operadora extends Model
{
    use HasFactory;
    protected $table = "operadora";
    public $timestamps = false;


    public function persona(){
      return $this->hasMany(Persona::class);
    }

}
