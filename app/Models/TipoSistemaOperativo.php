<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSistemaOperativo extends Model
{
    use HasFactory;
    protected $table = 'tipo_sistema_operativo';
    protected $primaryKey = 'codigo_sistema_operativo';
}
