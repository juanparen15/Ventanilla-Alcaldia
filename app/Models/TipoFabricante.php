<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFabricante extends Model
{
    use HasFactory;
    protected $table = 'tipo_fabricante';
    protected $primaryKey = 'codigo_fabricante';
}
