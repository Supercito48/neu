<?php

class ControllerCargaDeCandidatos
{
    /**
     * Punto de entrada para listar información del módulo Carga de candidatos.
     */
    public static function ctrMostrarCargaDeCandidatos()
    {
        return ModelCargaDeCandidatos::mdlMostrarCargaDeCandidatos();
    }
}
