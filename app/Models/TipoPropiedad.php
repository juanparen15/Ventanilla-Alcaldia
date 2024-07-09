<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPropiedad extends Model
{
    use HasFactory;
    protected $table = 'tipo_propiedad';
    protected $primaryKey = 'codigo_tipo_propiedad';
}
