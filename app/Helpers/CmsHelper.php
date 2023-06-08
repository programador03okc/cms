<?php

namespace App\Helpers;
use Carbon\Carbon;

class CmsHelper
{
    //Fecha debe ser un objeto de tipo Carbon
    public static function obtenerSeveridadFechaActualizacion($fecha) {
        $diferencia = $fecha->diffInMinutes(new Carbon());
        if ($diferencia <= 120) { //2 horas
            return 'success';
        } else if ($diferencia <= 240) { //4 horas
            return 'warning';
        } else {
            return 'danger';
        }
    }
}