<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMetodoPropulsion extends Model
{
    use HasFactory;
    protected $table = 'tipo_metodo_propulsion';
    protected $primaryKey = 'codigo_metodo_propulsion';
}
