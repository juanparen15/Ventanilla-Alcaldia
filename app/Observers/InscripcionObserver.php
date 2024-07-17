<?php

namespace App\Observers;

use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;

class InscripcionObserver
{

    // public function creating(Inscripcion $solicitud)
    // {
    //     $solicitud->documento_tercero = Auth::user()->username;
    // }

    /**
     * Handle the Inscripcion "created" event.
     */
    public function created(Inscripcion $Inscripcion): void
    {
        //
    }

    /**
     * Handle the Inscripcion "updated" event.
     */
    public function updated(Inscripcion $Inscripcion): void
    {
        //
    }

    /**
     * Handle the Inscripcion "deleted" event.
     */
    public function deleted(Inscripcion $Inscripcion): void
    {
        //
    }

    /**
     * Handle the Inscripcion "restored" event.
     */
    public function restored(Inscripcion $Inscripcion): void
    {
        //
    }

    /**
     * Handle the Inscripcion "force deleted" event.
     */
    public function forceDeleted(Inscripcion $Inscripcion): void
    {
        //
    }
}
