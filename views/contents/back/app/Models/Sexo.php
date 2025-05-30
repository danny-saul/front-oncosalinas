<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    use HasFactory;
    
    protected $table = "sexo";
    public $timestamps = false;

    public function persona(){
        return $this->HasMany(Persona::class);
    }
}
