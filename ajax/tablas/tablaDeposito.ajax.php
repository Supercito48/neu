<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/deposito.controller.php";
require_once "../../models/deposito.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
class TablaDeposito
{

    /*=============================================
	Tabla Personas
	=============================================*/

    public function mostrarTabla()
    {
        $idPerfil = $_SESSION["idPerfil"];
        $verdeposito = ControllerDeposito::ctrMostrarDeposito();

        $permisossum = ControllerPerfil::ctrMostrarMenuPermisos(42, $idPerfil);
        $permisosajus = ControllerPerfil::ctrMostrarMenuPermisos(43, $idPerfil);
        $permisostras = ControllerPerfil::ctrMostrarMenuPermisos(44, $idPerfil);
        $permisoselim = ControllerPerfil::ctrMostrarMenuPermisos(45, $idPerfil);
        if (count($verdeposito) == 0) {
            $datosJson = '[]';
            echo $datosJson;
            return;
        }

        $datosJson = '[';

        foreach ($verdeposito as $key => $value) {

            if ($permisossum["acronimo"] == "sumcent" && $permisossum["estado"] == "on" && $permisossum["existe"] == 1) {

                $aumentar=  "<span class='text-primary px-1 btnSumaDeposito' idDeposito='" . $value['idDeposito'] . "' style='cursor: pointer;' data-toggle='modal' data-target='#modalAumentoDeposito'>" .
                            "<i class='fas fa-plus-circle fa-2x'></i>" .
                            "</span>" ;
            }else{
                $aumentar=  "<span class='text-secondary px-1'>" .
                            "<i class='fas fa-plus-circle fa-2x'></i>" .
                            "</span>" ;
            }
           
            if ($permisosajus["acronimo"] == "ajuscent" && $permisosajus["estado"] == "on" && $permisosajus["existe"] == 1) {

                $ajustar=   "<span class='text-warning px-1 btnSumaDeposito' idDeposito='" . $value['idDeposito'] . "' style='cursor: pointer;' data-toggle='modal' data-target='#modalAjustarDeposito'>" .
                            "<i class='fas fa-sync fa-2x'></i>" .
                            "</span>" ;
            }else{
                $ajustar=   "<span class='text-secondary px-1' >" .
                            "<i class='fas fa-sync fa-2x'></i>" .
                            "</span>" ;
            }

            if ($permisostras["acronimo"] == "trascent" && $permisostras["estado"] == "on" && $permisostras["existe"] == 1) {

                $traslado=  "<span class='text-orange px-1 btnSumaDeposito' style='cursor: pointer;' idDeposito='" . $value['idDeposito'] . "' data-toggle='modal' data-target='#modalTraslado'>" .
                            "<i class='fas fa-truck fa-2x'></i>" .
                            "</span>" ;
            }else{
                $traslado=  "<span class='text-secondary px-1' >" .
                            "<i class='fas fa-truck fa-2x'></i>" .
                            "</span>" ;
            }
           
            if ($permisoselim["acronimo"] == "elimcent" && $permisoselim["estado"] == "on" && $permisoselim["existe"] == 1) {

                $eliminar=  "<span class='text-danger px-1 eliminarDeposito' style='cursor: pointer;' idDeposito='" . $value['idDeposito'] . "' stock='" . $value['stock'] . "' idProducto='" . $value['idProducto'] . "'>" .
                            "<i class='fas fa-trash fa-2x'></i>" .
                            "</span>";
            }else{
                $eliminar=  "<span class='text-secondary px-1'>" .
                            "<i class='fas fa-trash fa-2x'></i>" .
                            "</span>";
            }
           
            

            $acciones = "{$aumentar}{$ajustar}{$traslado}{$eliminar}";

//            $acciones = "<span class='text-primary px-1 btnSumaDeposito' idDeposito='" . $value['idDeposito'] . "' style='cursor: pointer;' data-toggle='modal' data-target='#modalAumentoDeposito'><i class='fas fa-plus-circle fa-2x'></i></span> <span class='text-warning px-1 btnSumaDeposito' idDeposito='" . $value['idDeposito'] . "' style='cursor: pointer;' data-toggle='modal' data-target='#modalAjustarDeposito'><i class='fas fa-sync fa-2x'></i></span><span class='text-orange px-1 btnSumaDeposito' style='cursor: pointer;' idDeposito='" . $value['idDeposito'] . "' data-toggle='modal' data-target='#modalTraslado'><i class='fas fa-truck fa-2x'></i></span><span class='text-danger px-1 eliminarDeposito' style='cursor: pointer;' idDeposito='" . $value['idDeposito'] . "' stock='" . $value['stock'] . "' idProducto='" . $value['idProducto'] . "'><i class='fas fa-trash fa-2x'></i></span>";

            $datosJson .= '{
						"idDeposito ": "' . ($key + 1) . '",
                        "codigoBarras ": "' . $value["codigoBarras"] . '",
						"descProducto": "' . $value["descProducto"] . '",
						"stock": "' . $value["stock"] . '",
                        "acciones" : "' . $acciones . '"
			},';
        }
        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=  ']';
        echo $datosJson;
    }
}

$tabla = new TablaDeposito();
$tabla->mostrarTabla();
