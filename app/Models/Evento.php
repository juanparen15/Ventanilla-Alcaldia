<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'evento';
    protected $primaryKey = 'codigo_evento';

    public function modalidades()
    {
        return $this->hasMany(EventoDetalleModalidadesArma::class, 'codigo_evento', 'codigo_evento');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'codigo_evento');
    }
}
