<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEstadoInscripcion extends Model
{
    use HasFactory;
    protected $table = 'tipo_estado_inscripcion';
    protected $primaryKey = 'codigo_tipo_estado_inscripcion';
}
