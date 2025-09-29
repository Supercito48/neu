<?php
session_start();

require_once "../controllers/actas.controller.php";
require_once "../models/actas.model.php";
require_once "../models/rutas.php";

class AjaxActas
{
    public $idProvincia;
    public $ubigeo;
    public $datosActa;
    public $detalleCandidatos;

    public function ajaxListarProvincias()
    {
        $respuesta = ControladorActas::ctrListarProvincias();
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxListarDistritos()
    {
        $respuesta = ControladorActas::ctrListarDistritos($this->idProvincia);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxListarCandidatos()
    {
        $respuesta = ControladorActas::ctrListarCandidatos($this->ubigeo);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxGuardarActa()
    {
        foreach ($this->datosActa as $campo => $valor) {
            if ($valor === null || $valor === '') {
                echo json_encode([
                    "status" => "error",
                    "mensaje" => "Complete todos los campos obligatorios del acta."
                ]);
                return;
            }
        }

        if (empty($this->detalleCandidatos)) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "Debe registrar los votos de al menos un candidato."
            ]);
            return;
        }

        foreach ($this->detalleCandidatos as $detalle) {
            if (!isset($detalle["codigo_agrupacion"], $detalle["votos"]) || !is_numeric($detalle["votos"])) {
                echo json_encode([
                    "status" => "error",
                    "mensaje" => "Los votos de los candidatos no son válidos."
                ]);
                return;
            }
        }

        if (!isset($_FILES["fotoActa"]) || $_FILES["fotoActa"]["error"] !== UPLOAD_ERR_OK) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "Debe adjuntar la fotografía del acta."
            ]);
            return;
        }

        $foto = $_FILES["fotoActa"];
        $extension = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));
        $permitidos = ["jpg", "jpeg", "png"];

        if (!in_array($extension, $permitidos, true)) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "La fotografía del acta debe estar en formato JPG o PNG."
            ]);
            return;
        }

        $directorio = "../uploads/actas/";

        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = uniqid("acta_") . "." . $extension;
        $rutaFisica = $directorio . $nombreArchivo;
        $rutaRelativa = "uploads/actas/" . $nombreArchivo;

        if (!move_uploaded_file($foto["tmp_name"], $rutaFisica)) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "No se pudo guardar la fotografía del acta."
            ]);
            return;
        }

        $resultado = ControladorActas::ctrRegistrarActa(
            array_merge($this->datosActa, ["ruta_acta" => $rutaRelativa]),
            $this->detalleCandidatos
        );

        if ($resultado === "ok") {
            echo json_encode([
                "status" => "ok",
                "mensaje" => "El acta se registró correctamente."
            ]);
            return;
        }

        if (file_exists($rutaFisica)) {
            unlink($rutaFisica);
        }

        if ($resultado === "duplicado") {
            echo json_encode([
                "status" => "error",
                "mensaje" => "Ya existe un acta registrada para la mesa seleccionada."
            ]);
            return;
        }

        echo json_encode([
            "status" => "error",
            "mensaje" => "Ocurrió un problema al registrar el acta."
        ]);
    }
}

$accion = $_GET["accion"] ?? $_POST["accion"] ?? null;

switch ($accion) {
    case "listarProvincias":
        $ajax = new AjaxActas();
        $ajax->ajaxListarProvincias();
        break;
    case "listarDistritos":
        $ajax = new AjaxActas();
        $ajax->idProvincia = $_POST["idProvincia"] ?? null;
        $ajax->ajaxListarDistritos();
        break;
    case "listarCandidatos":
        $ajax = new AjaxActas();
        $ajax->ubigeo = $_POST["ubigeo"] ?? null;
        $ajax->ajaxListarCandidatos();
        break;
    case "guardarActa":
        $ajax = new AjaxActas();
        $datosJson = $_POST["candidatos"] ?? "";
        $detalle = json_decode($datosJson, true);

        if (!is_array($detalle)) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "No se pudo leer la relación de votos enviados."
            ]);
            return;
        }

        $ajax->detalleCandidatos = $detalle;
        $ajax->datosActa = [
            "ubigeo" => isset($_POST["ubigeo"]) ? trim($_POST["ubigeo"]) : null,
            "mesa_sufragio" => isset($_POST["mesa_sufragio"]) ? (int) $_POST["mesa_sufragio"] : null,
            "total_reniec_habiles" => isset($_POST["total_reniec_habiles"]) ? (float) $_POST["total_reniec_habiles"] : null,
            "vt_blanco_dist" => isset($_POST["vt_blanco_dist"]) ? (float) $_POST["vt_blanco_dist"] : null,
            "vt_nulo_dist" => isset($_POST["vt_nulo_dist"]) ? (float) $_POST["vt_nulo_dist"] : null,
            "vt_impugnado_dist" => isset($_POST["vt_impugnado_dist"]) ? (float) $_POST["vt_impugnado_dist"] : null,
            "total_vt_emitidos_dist" => isset($_POST["total_vt_emitidos_dist"]) ? (float) $_POST["total_vt_emitidos_dist"] : null,
        ];
        $ajax->ajaxGuardarActa();
        break;
    default:
        echo json_encode([]);
        break;
}
