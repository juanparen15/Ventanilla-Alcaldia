<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = 'inscripcion';
    protected $primaryKey = 'codigo_inscripcion';
    protected $fillable = [
        'documento_tercero',
        'acepta_politicas',
        'codigo_tipo_categoria',
        'codigo_evento',
        'comprobante_pago',
        'codigo_tipo_estado_inscripcion',
        'valor',
        'user_id',
    ];
    public function scopeCurrentUser($query)
    {
        if (Auth::user()->role_id == 2) {
            return $query->where('documento_tercero', Auth::user()->username);
        } else {
            // Si el usuario no está autenticado o su role_id no es igual a 2, retornamos una consulta vacía
            // return $query->where('id', '=', null);
        }
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'codigo_evento');
    }

    public function tipoCategoria()
    {
        return $this->belongsTo(TipoCategoria::class, 'codigo_tipo_categoria');
    }

    public function armas()
    {
        return $this->hasMany(Arma::class, 'codigo_arma', 'codigo_arma');
    }


    protected static function boot()
    {
        parent::boot();

        // Utiliza el evento creating para establecer el campo documento_tercero y categoría
        static::creating(function ($inscripcion) {
            // Verifica si hay un usuario autenticado
            if (Auth::check()) {
                $user = Auth::user();
                $inscripcion->documento_tercero = $user->username;
                $inscripcion->user_id = $user->id;

                // Establecer el estado predeterminado como 'Borrador'
                $inscripcion->codigo_tipo_estado_inscripcion = 1;
            }
        });
        static::updating(function ($inscripcion) {
            // Verifica si hay un usuario autenticado
            if (Auth::check()) {
                $user = Auth::user();
                $inscripcion->documento_tercero = $user->username;
                $inscripcion->user_id = $user->id;

                // Establecer el estado predeterminado como 'Borrador'
                $inscripcion->codigo_tipo_estado_inscripcion = 1;
            }
        });
        static::saving(function ($model) {
            if (is_array($model->codigo_tipo_arma_evento)) {
                $model->codigo_tipo_arma_evento = json_encode($model->codigo_tipo_arma_evento);
            }
            if (is_array($model->codigo_arma)) {
                $model->codigo_arma = json_encode($model->codigo_arma);
            }
        });
    }
}
