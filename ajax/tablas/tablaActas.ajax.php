<?php
session_start();

require_once "../../controllers/actas.controller.php";
require_once "../../models/actas.model.php";
require_once "../../models/rutas.php";

class TablaActas
{
    public function mostrarTabla()
    {
        $actas = ControladorActas::ctrListarActas();

        if (empty($actas)) {
            echo '[]';
            return;
        }

        $ruta = new Ruta();
        $urlBase = $ruta->ctrRuta();

        $filas = [];

        foreach ($actas as $acta) {
            $enlace = '<span class="badge badge-secondary">Sin archivo</span>';

            if (!empty($acta["ruta_acta"])) {
                $urlArchivo = $urlBase . $acta["ruta_acta"];
                $enlace = "<a href='" . $urlArchivo . "' target='_blank' class='btn btn-info btn-sm'><i class='fas fa-image'></i> Ver acta</a>";
            }

            $filas[] = [
                "provincia" => $acta["provincia"] ?? "-",
                "distrito" => $acta["nom_distrito"] ?? "-",
                "mesa" => $acta["mesa_sufragio"],
                "total_habiles" => $acta["total_reniec_habiles"],
                "blanco" => $acta["vt_blanco_dist"],
                "nulo" => $acta["vt_nulo_dist"],
                "impugnado" => $acta["vt_impugnado_dist"],
                "emitidos" => $acta["total_vt_emitidos_dist"],
                "foto" => $enlace,
            ];
        }

        echo json_encode($filas, JSON_UNESCAPED_UNICODE);
    }
}

$tabla = new TablaActas();
$tabla->mostrarTabla();
