<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadArma extends Model
{
    use HasFactory;
    protected $table = 'modalidad_arma';

    protected $fillable = ['tipo_arma', 'modalidad'];

    public function tipoArma()
    {
        return $this->belongsTo(TipoArma::class, 'tipo_arma');
    }
}
