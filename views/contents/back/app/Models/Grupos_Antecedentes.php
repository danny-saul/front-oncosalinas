<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos_Antecedentes extends Model
{
    use HasFactory;
    protected $table = "grupos_antecedentes";
    protected $filleable = ['nombre','estado'];
    public $timestamps = false;


    public function antecedentes(){
        return $this->hasMany(Antecedentes::class,'grupos_antecedentes_id');
    }
}
