<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCategoria extends Model
{
    use HasFactory;
    protected $table = 'tipo_categoria';
    protected $primaryKey = 'codigo_tipo_categoria';


    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'codigo_tipo_categoria');
    }
}
