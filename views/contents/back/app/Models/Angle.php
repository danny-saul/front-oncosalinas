<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angle extends Model
{
    use HasFactory;

    protected $table = "angle";
    protected $fillable = ['tipo','estado'];
    public $timestamps = false;

    public function paciente_angle(){
        return $this->hasMany(Paciente_Angle::class);
    }

}
