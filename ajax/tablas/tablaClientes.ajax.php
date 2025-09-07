<?php
session_start();

require_once "../../controllers/clientes.controller.php";
require_once "../../models/clientes.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";


class TablaClientes
{

	/*=============================================
	Tabla Personas
	=============================================*/

	public function mostrarTabla()
	{

		$idPerfil = $_SESSION["idPerfil"];

		$cliente = ControllerClientes::ctrMostrarClientes(null, null);

		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(64, $idPerfil);
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(65, $idPerfil);
		$permisospag = ControllerPerfil::ctrMostrarMenuPermisos(66, $idPerfil);
		$permisoshst = ControllerPerfil::ctrMostrarMenuPermisos(67, $idPerfil);

		

		if (count($cliente) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($cliente as $key => $value) {

			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
			
			if ($permisosedit["acronimo"] == "editcli" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1) {
				$editar =  "<button class='btn btn-warning editarCliente' data-toggle='modal' data-target='#modalClientes' idCliente='" . $value["idCliente"] . "'><i class='fa fa-edit'></i></button>";
			} else {
				$editar =  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>";
			}

			if ($permisoseli["acronimo"] == "elimcli" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1) {
				$eliminar =  "<button class='btn btn-danger eliminarCliente'idCliente='" . $value["idCliente"] . "' ><i class='fa fa-times'></i></button>";
			} else {
				$eliminar =  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>";
			}

			/*if ($value["limite_credito"] != $value["credito_usado"]) {
				$pagar = "<button class='btn btn-success pagarCredito' data-toggle='modal' data-target='#moda_pagar'  idCliente='" . $value["idCliente"] . "'  title='Pagar deuda'><i class='fas fa-hand-holding-usd'></i></button>";
				$historial = "";
			} else {
				if ($value["idCliente"] == 1) {
					$historial = "";
					$pagar = "";
				} 
				$pagar = "";
				
				
			}*/

			if ($value["limite_credito"] == $value["credito_usado"] ) {
				$pagar = "";
				$historial = "<button class='btn btn-primary btnverHistorial' idCliente='" . $value["idCliente"] . "' title='Ver Historial'><i class='fab fa-cc-visa'></i></button>";
				if ($value["idCliente"] == 1) {
					$historial = "";
				} 
			} else {
				
				$pagar = "<button class='btn btn-success pagarCredito' data-toggle='modal' data-target='#moda_pagar'  idCliente='" . $value["idCliente"] . "'  title='Pagar deuda'><i class='fas fa-hand-holding-usd'></i></button>";
				$historial = "<button class='btn btn-primary btnverHistorial' idCliente='" . $value["idCliente"] . "' title='Ver Historial'><i class='fab fa-cc-visa'></i></button>";
				

			}

			
			
			if ($permisospag["acronimo"] == "pagcre" && $permisospag["estado"] == "on" && $permisospag["existe"] == 1 && $permisoshst["acronimo"] == "verhst" && $permisoshst["estado"] == "on" && $permisoshst["existe"] == 1) {
				$acciones = "<div class='btn-group' style='text-align: center;'>{$pagar}{$historial}{$editar}{$eliminar}</div>";
			} else if ($permisospag["acronimo"] == "pagcre" && $permisospag["estado"] == "on" && $permisospag["existe"] == 1) {
				$acciones = "<div class='btn-group' style='text-align: center;'>{$pagar}{$editar}{$eliminar}</div>";
			} else if ($permisoshst["acronimo"] == "verhst" && $permisoshst["estado"] == "on" && $permisoshst["existe"] == 1) {
				$acciones = "<div class='btn-group' style='text-align: center;'>{$historial}{$editar}{$eliminar}</div>";
			} else {
				$acciones = "<div class='btn-group' style='text-align: center;'>{$editar}{$eliminar}</div>";
			}


			$datosJson .= '{
						"idCliente ": "' . ($key + 1) . '",
                        "dni ": "' . $value["dni"] . '",
						"nombres": "' . $value["nombres"] . '",
						"direccion": "' . $value["direccion"] . '",
						"telefono" : "' . $value["telefono"] . '",
                        "limite_credito" :  " '.$configuracion[0]["simbolom"].' ' . number_format($value["limite_credito"], 2, ',', '.'). '",
						"credito_usado" :   " '.$configuracion[0]["simbolom"].' ' .number_format($value["credito_usado"], 2, ',', '.') . '",
                        "acciones" : "' . $acciones . '"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

$tabla = new TablaClientes();
$tabla->mostrarTabla();