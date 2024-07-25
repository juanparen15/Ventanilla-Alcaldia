<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetalleInscripcion extends Model
{
    use HasFactory;

    protected $table = 'detalle_inscripcion';
    protected $primaryKey = 'codigo_detalle_inscripcion';
    protected $fillable = [
        'user_id',
        'documento_tercero',
        'codigo_inscripcion',
        'codigo_evento_detalle',
        'codigo_arma',
        'puntaje',
        // 'observaciones',
    ];

    public function eventoDetalle()
    {
        return $this->belongsTo(EventoDetalleModalidadesArma::class, 'codigo_evento_detalle', 'codigo_evento_detalle');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function arma()
    {
        return $this->belongsTo(Arma::class, 'codigo_arma', 'codigo_arma');
    }

    public function scopeCurrentUser($query)
    {
        if (Auth::user()->role_id == 2) {
            // $this->documento_tercero = Auth::user()->username;
            return $query->where('documento_tercero', Auth::user()->username);
        } else {
            // Si el usuario no está autenticado o su role_id no es igual a 2, retornamos una consulta vacía
            // return $query->where('id', '=', null);
        }
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     // Utiliza el evento creating para establecer el campo documento_tercero
    //     static::creating(function ($detalle_inscripcion) {
    //         // Verifica si hay un usuario autenticado
    //         if (Auth::check()) {
    //             // Establece el valor del campo documento_tercero como el nombre de usuario del usuario autenticado
    //             $detalle_inscripcion->documento_tercero = Auth::user()->username;
    //             $detalle_inscripcion->user_id = Auth::user()->id;
    //         }
    //     });
    // }
}
