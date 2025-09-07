<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
class TablaPerfil
{
	/*=============================================
	Tabla Tipopago
	=============================================*/

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$tipoperfil = ControllerPerfil::ctrMostrarPerfil(null, null,null);
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(23, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(24, $idPerfil); 

		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($tipoperfil) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($tipoperfil as $key => $value) {


			if($value["estado"] == 1){
				$eliminar= "<button class='btn btn-success btnActivarPerfil'><i class='fa fa-check'></i></button>";
			}else{
				$eliminar= "<button class='btn btn-danger btnEliminarPerfil'><i class='fa fa-times'></i></button>";
			}

			/*=============================================
			ACCIONES
			=============================================*/
			if ($permisosedit["acronimo"] == "editperfil" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
				$editar = "<button class='btn btn-warning btnEditarPerfil'  data-toggle='modal' data-target='#myModal'><i class='fa fa-edit'></i></button>";
			}else{
				$editar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

			if ($permisoseli["acronimo"] == "elimperfil" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				if($value["estado"] == 1){
					$eliminar= "<button class='btn btn-success btnActivarPerfil'><i class='fa fa-check'></i></button>";
				}else{
					$eliminar= "<button class='btn btn-danger btnEliminarPerfil'><i class='fa fa-times'></i></button>";
				}
			}else{
				$eliminar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

			// $nombre =$value["nomper"];
			$permisos = "<button class='btn btn-secondary btnPermisos' idPerfiles='".$value["idPerfiles"]."' data-toggle='modal' data-target='#modal_permisos'><i class='fas fa-key'></i></button>";
		
          

		
			$datosJson .= '{
						"idPerfiles": "' . ($key + 1) . '",
						"idPerfiles2": "' . $value["idPerfiles"] . '",
						"descripcion": "' . $value["descripcion"] . '",
						"permisos" : "' . $permisos . '",
						"editar" : "' . $editar . '",
                        "eliminar" : "'.$eliminar.'"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

/*=============================================
Tabla Tipopago
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaPerfil();
$tabla->mostrarTabla();