<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalibre extends Model
{
    use HasFactory;
    protected $table = 'tipo_calibre';
    protected $primaryKey = 'codigo_calibre';
}
