<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorModalidadesPorTipoArma extends Model
{
    use HasFactory;
    protected $table = 'valor_modalidades_por_tipo_arma';
    protected $primaryKey = 'codigo_valor_modalidades';
}
