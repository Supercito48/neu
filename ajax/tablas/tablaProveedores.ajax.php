<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/proveedores.controller.php";
require_once "../../models/proveedores.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
class TablaProveedores
{

	/*=============================================
	Tabla Personas
	=============================================*/

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$proveedores = ControllerProveedores::ctrMostrarProveedores(null, null);
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(15, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(16, $idPerfil); 
		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($proveedores) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($proveedores as $key => $value) {
            //Si el email2 esta vacio entonces no saldra N/A, pero si tiene datos traera lo que esta en la bd
			if($value["email"] == ""){
				$email = "N/A";
			}else{
				$email = $value["email"];
			}

			// //Si el telefono2per esta vacio entonces no saldra N/A, pero si tiene datos traera lo que esta en la bd
			if($value["telefono"] == ""){
				$telefono = "N/A";
			}else{
				$telefono = $value["telefono"];
			}
			

			/*=============================================
			ACCIONES
			=============================================*/
			if ($permisosedit["acronimo"] == "editprov" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1 && $permisoseli["acronimo"] == "elimprov" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				
				$acciones = "<div class='btn-group'><button class='btn btn-warning editarProveedores' data-toggle='modal' data-target='#modalProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-times'></i></button></div>";
			
			}else if ($permisosedit["acronimo"] == "editprov" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
				
				$acciones = "<div class='btn-group'><button class='btn btn-warning editarProveedores' data-toggle='modal' data-target='#modalProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-edit'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button></div>";
			
			}else if ($permisoseli["acronimo"] == "elimprov" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-danger eliminarProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-times'></i></button></div>";
			
			}else{
				
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button></div>";
			
			}
			
			// $nombre =$value["nomper"];
			//$acciones = "<div class='btn-group'><button class='btn btn-warning editarProveedores' data-toggle='modal' data-target='#modalProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarProveedores' idProveedor='".$value["idProveedor"]."'><i class='fa fa-times'></i></button></div>";

			$datosJson .= '{
						"idProveedor": "' . ($key + 1) . '",
						"RUC": "' . $value["RUC"] . '",
						"nombre": "' . $value["nombre"] . '",
						"direccion": "' . $value["direccion"] . '",
						"celular": "' . $value["celular"] . '",
                        "telefono": "' . $telefono . '",
                        "email": "' . $email . '",
						"acciones" : "' . $acciones . '"
			},';
		}
		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

/*=============================================
Tabla Categorias
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaProveedores();
$tabla->mostrarTabla();