<?php

class ControladorActas
{
    public static function ctrListarProvincias()
    {
        return ModeloActas::mdlListarProvincias();
    }

    public static function ctrListarDistritos($idProvincia)
    {
        return ModeloActas::mdlListarDistritos($idProvincia);
    }

    public static function ctrListarCandidatos($ubigeo)
    {
        return ModeloActas::mdlListarCandidatos($ubigeo);
    }

    public static function ctrRegistrarActa($datosActa, $detalleCandidatos)
    {
        return ModeloActas::mdlRegistrarActa($datosActa, $detalleCandidatos);
    }

    public static function ctrListarActas()
    {
        return ModeloActas::mdlListarActas();
    }
}
