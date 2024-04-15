<?php

namespace App\Observers;

use App\Models\ArmorumappSolicitud;
use Illuminate\Support\Facades\Auth;

class ArmorumappSolicitudObserver
{

    // public function creating(ArmorumappSolicitud $solicitud)
    // {
    //     $solicitud->documento_tercero = Auth::user()->username;
    // }

    /**
     * Handle the ArmorumappSolicitud "created" event.
     */
    public function created(ArmorumappSolicitud $armorumappSolicitud): void
    {
        //
    }

    /**
     * Handle the ArmorumappSolicitud "updated" event.
     */
    public function updated(ArmorumappSolicitud $armorumappSolicitud): void
    {
        //
    }

    /**
     * Handle the ArmorumappSolicitud "deleted" event.
     */
    public function deleted(ArmorumappSolicitud $armorumappSolicitud): void
    {
        //
    }

    /**
     * Handle the ArmorumappSolicitud "restored" event.
     */
    public function restored(ArmorumappSolicitud $armorumappSolicitud): void
    {
        //
    }

    /**
     * Handle the ArmorumappSolicitud "force deleted" event.
     */
    public function forceDeleted(ArmorumappSolicitud $armorumappSolicitud): void
    {
        //
    }
}
