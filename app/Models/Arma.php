<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Arma extends Model
{
    use HasFactory;

    protected $table = 'arma';
    protected $primaryKey = 'codigo_arma';

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

    protected static function boot()
    {
        parent::boot();

        // Utiliza el evento creating para establecer el campo documento_tercero
        static::creating(function ($arma) {
            // Verifica si hay un usuario autenticado
            if (Auth::check()) {
                // Establece el valor del campo documento_tercero como el nombre de usuario del usuario autenticado
                $arma->documento_tercero = Auth::user()->username;
                $arma->user_id = Auth::user()->id;
            }
        });
        // // Utiliza el evento creating para establecer el campo documento_tercero
        // static::updating(function ($arma) {
        //     // Verifica si hay un usuario autenticado
        //     if (Auth::check()) {
        //         // Establece el valor del campo documento_tercero como el nombre de usuario del usuario autenticado
        //         $arma->documento_tercero = Auth::user()->username;
        //         $arma->user_id = Auth::user()->id;
        //     }
        // });
    }

    public function metodoPropulsion()
    {
        return $this->belongsTo(TipoMetodoPropulsion::class, 'codigo_metodo_propulsion');
    }

    public function tipoArma()
    {
        return $this->belongsTo(TipoArma::class, 'codigo_tipo_arma');
    }

    public function calibre()
    {
        return $this->belongsTo(TipoCalibre::class, 'codigo_calibre');
    }

    public function tipoPropiedad()
    {
        return $this->belongsTo(TipoPropiedad::class, 'codigo_tipo_propiedad');
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'codigo_inscripcion', 'codigo_inscripcion');
    }
}
