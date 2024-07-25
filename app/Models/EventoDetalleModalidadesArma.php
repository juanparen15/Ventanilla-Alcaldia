<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoDetalleModalidadesArma extends Model
{
    use HasFactory;
    protected $table = 'evento_detalle_modalidades_armas';
    protected $primaryKey = 'codigo_evento_detalle';

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'codigo_evento', 'codigo_evento');
    }

    public function tipoArma()
    {
        return $this->belongsTo(TipoArma::class, 'codigo_tipo_arma', 'id');
    }

    public function tipoModalidadArma()
    {
        return $this->belongsTo(ModalidadArma::class, 'codigo_tipo_modalidad_arma', 'id');
    }

    public function detalleInscripciones()
    {
        return $this->hasMany(DetalleInscripcion::class, 'codigo_evento_detalle', 'codigo_evento_detalle');
    }
}
