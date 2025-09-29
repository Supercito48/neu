<?php

require_once "conexion.php";

class ModelCargaDeCandidatos
{
    public static function mdlMostrarCargaDeCandidatos()
    {
        $stmt = Conexion::conectar()->prepare("SELECT 1");
        $stmt->execute();
        return $stmt->fetch();
    }
}
