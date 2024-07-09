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
    protected $fillable = ['codigo_tipo_estado_inscripcion', 'categoria'];

    public function scopeCurrentUser($query)
    {
        if (Auth::user()->role_id == 2) {
            return $query->where('documento_tercero', Auth::user()->username);
        } else {
            // Si el usuario no está autenticado o su role_id no es igual a 2, retornamos una consulta vacía
            // return $query->where('id', '=', null);
        }
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

                // Calcular la categoría basada en la fecha de nacimiento del usuario
                $birthdate = new Carbon($user->fecha_nacimiento);
                $age = $birthdate->age;

                if ($age < 18) {
                    $inscripcion->categoria = 'Juvenil';
                } elseif ($age <= 35) {
                    $inscripcion->categoria = 'Mayores';
                } else {
                    $inscripcion->categoria = 'Senior';
                }
            }
        });
    }
}
