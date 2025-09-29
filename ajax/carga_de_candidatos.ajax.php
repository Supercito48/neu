<?php

require_once "../controllers/carga_de_candidatos.controller.php";
require_once "../models/carga_de_candidatos.model.php";

class AjaxCargaDeCandidatos
{
    public function ajaxMostrarCargaDeCandidatos()
    {
        $respuesta = ControllerCargaDeCandidatos::ctrMostrarCargaDeCandidatos();
        echo json_encode($respuesta);
    }
}

if (isset($_POST["mostrarCarga_de_candidatos"])) {
    $ajax = new AjaxCargaDeCandidatos();
    $ajax->ajaxMostrarCargaDeCandidatos();
}
