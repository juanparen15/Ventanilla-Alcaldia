<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class BotonDetalles extends AbstractAction
{
    public function getTitle()
    {
        return 'Detalles';
    }

    public function getIcon()
    {
        return 'voyager-window-list';
    }

    public function getPolicy()
    {
        return null;
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right detalle-inscripcion',
            'data-id' => $this->data->{$this->data->getKeyName()}, // Agrega el ID de inscripción como un atributo de datos
            'href' => 'javascript:void(0);' // Evita que el enlace redirija
        ];
    }

    public function getDefaultRoute()
    {
        return 'javascript:void(0);';
    }

    public function shouldActionDisplayOnDataType()
    {
        // Muestra el botón solo en la sección deseada
        return $this->dataType->slug === 'inscripcion';
    }
}