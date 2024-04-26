<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArma extends Model
{
    use HasFactory;
    protected $table = 'tipo_arma';

    // public function setArmaAttribute($value)
    // {
    //     $this->attributes['arma'] = json_encode($value);
    // }

    // /**
    //  * Get the a
    //  *
    //  */
    // public function getArmaAttribute($value)
    // {
    //     return $this->attributes['arma'] = json_decode($value);
    // }
}
