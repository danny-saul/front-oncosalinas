<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Via extends Model
{
    use HasFactory;
      protected $table = 'via';
      public $timestamps = false;

       public function receta_detalle(){
        return $this->hasMany(Receta_Detalle::class);
    }

}
