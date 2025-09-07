<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/comprobante.controller.php";
require_once "../../models/comprobante.model.php";

require_once "../../controllers/almacen.controller.php";
require_once "../../models/almacen.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";


class TablaComprobante
{

	/*=============================================
	Tabla Personas
	=============================================*/

	public function mostrarTabla()
	{

		$idPerfil = $_SESSION["idPerfil"];
        $idAlmacen = $_SESSION["idAlmacen"];

        if ($_SESSION["idPerfil"] == 0) {

            $comprobante = ControllerComprobantes::ctrMostrarComprobantes(null,null);
        } else {

            $comprobante = ControllerComprobantes::ctrMostrarComprobantes("idAlmacen", $idAlmacen);
        }
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(54, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(55, $idPerfil); 
      //  $idAlmacen = $_SESSION["idAlmacen"];
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
	//	$comprobante = ControllerComprobantes::ctrMostrarComprobantes("idAlmacen", $idAlmacen);


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($comprobante) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($comprobante as $key => $value) {


			if ($permisosedit["acronimo"] == "editcomprob" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1) {
                $editar=  "<button class='btn btn-warning editarComprobante' data-toggle='modal' data-target='#modalComprobante' idDocalmacen='".$value["idDocalmacen"]."'><i class='fa fa-edit'></i></button>";
            }else{
                $editar=  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>" ;
            }

			if ($permisoseli["acronimo"] == "elimcomprob" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1) {
                $eliminar=  "<button class='btn btn-danger eliminarComprobante'idDocalmacen='".$value["idDocalmacen"]."' ><i class='fa fa-times'></i></button>";
            }else{
                $eliminar=  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>" ;
            }


            $almacen = ControllerAlmacen::ctrMostrarAlmacen("idAlmacen", $value["idAlmacen"]);
            $acciones = "{$editar}{$eliminar}";
	
			$datosJson .= '{
						"idDocalmacen ": "' . ($key + 1) . '",
                        "descAlmacen ": "' . $almacen["descripcion"] . '",
						"Documento": "' . $value["Documento"] . '",
						"Serie": "' . $value["Serie"] . '",
						"Cantidad" : "' . $value["Cantidad"] . '",
                        "acciones" : "'.$acciones.'"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

$tabla = new TablaComprobante();
$tabla->mostrarTabla();