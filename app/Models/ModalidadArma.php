<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadArma extends Model
{
    use HasFactory;
    protected $table = 'modalidad_arma';

    protected $fillable = ['tipo_arma'];


    public function setTipormaAttribute($value)
    {
        $this->attributes['tipo_arma'] = json_encode($value);
    }

    /**
     * Get the tipo_arma
     *
     */
    public function getTipormaAttribute($value)
    {
        return $this->attributes['tipo_arma'] = json_decode($value);
    }
}
