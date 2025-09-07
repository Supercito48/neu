<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/almacen.controller.php";
require_once "../../models/almacen.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

class TablaAlmacen
{

	/*=============================================
	Tabla Almacen
	=============================================*/
	

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$almacen = ControllerAlmacen::ctrMostrarAlmacen(null, null,null);

		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(3, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(4, $idPerfil); 


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($almacen) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($almacen as $key => $value) {


			if($value["estado"] == 0){	
                $estado = "<button class='btn btn-danger btn-sm btnActivarAlm' estado='1' idAlmacen='".$value["idAlmacen"]."'><i class='fa fa-toggle-off'></i>Desactivado</button>";
            }else{
				$estado = "<button class='btn btn-success btn-sm btnActivarAlm' estado='0'  idAlmacen='".$value["idAlmacen"]."'><i class='fa fa-toggle-on'></i> Activado</button>";
            }

			if ($permisosedit["acronimo"] == "editalmacen" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
				$editar = "<button class='btn btn-warning editarAlmacen' data-toggle='modal' data-target='#modalAlmacen' idAlmacen='".$value["idAlmacen"]."'><i class='fa fa-edit'></i></button>";
			}else{
				$editar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

			if ($permisoseli["acronimo"] == "elimalmacen" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				$eliminar= "<button class='btn btn-danger eliminarAlmacen'idAlmacen='".$value["idAlmacen"]."'><i class='fa fa-times'></i></button>";
			}else{
				$eliminar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

           

       

			/*=============================================
			ACCIONES
			=============================================*/

			// $nombre =$value["nomper"];
	

		
			$datosJson .= '{
						"idAlmacen": "' . ($key + 1) . '",
						"descripcion": "' . $value["descripcion"] . '",
						"ubicacion": "' . $value["ubicacion"] . '",
						"entrada": "'.$value["entrada"].'",
						"salida": "'.$value["salida"].'",
						"estado": "'.$estado.'",
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
Tabla Almacen
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaAlmacen();
$tabla->mostrarTabla();