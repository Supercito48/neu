<?php
session_start();
require_once "../../controllers/usuarios.controller.php";
require_once "../../models/usuarios.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

require_once "../../controllers/empleado.controller.php";
require_once "../../models/empleado.model.php";

require_once "../../controllers/almacen.controller.php";
require_once "../../models/almacen.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

class TablaUsuario
{
	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		$usuario = ControllerUsuarios::ctrMostrarUsuario(null, null,null);
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(11, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(12, $idPerfil); 
		if (count($usuario) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';
	
		foreach ($usuario as $key => $value) {

			$empleado = ControllerEmpleado::ctrMostrarEmpleado("idEmpleado", $value["idEmpleado"]);
            $almacen = ControllerAlmacen::ctrMostrarAlmacen("idAlmacen", $value["idAlmacen"]);
			$perfil = ControllerPerfil::ctrMostrarPerfil("idPerfiles", $value["idPerfil"]);
			

			if ($permisosedit["acronimo"] == "editusuarios" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1 && $permisoseli["acronimo"] == "elimusuarios" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				
				$acciones = "<div class='btn-group'>".
							"<button class='btn btn-warning editarUsuario' data-toggle='modal' data-target='#modalUsuarios' idUsuario='".$value["idUsuario"]."'>".
							"<i class='fa fa-edit'></i>".
							"</button>".
							"<button class='btn btn-danger eliminarUsuario'idUsuario='".$value["idUsuario"]."'>".
							"<i class='fa fa-times'></i>".
							"</button>";
			
			}else if ($permisosedit["acronimo"] == "editusuarios" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
			
				$acciones = "<div class='btn-group'><button class='btn btn-warning editarUsuario' data-toggle='modal' data-target='#modalUsuarios' idUsuario='".$value["idUsuario"]."'><i class='fa fa-edit'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			
			}else if ($permisoseli["acronimo"] == "elimusuarios" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
			
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-danger eliminarUsuario'idUsuario='".$value["idUsuario"]."'><i class='fa fa-times'></i></button>";
			
			}else{
			
				$acciones = "<div class='btn-group'><button class='btn btn-secondary'><i class='fas fa-ban'></i></button><button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			
			}
			
			
			$datosJson .= '{
						"idUsuario": "' . ($key + 1) . '",
						"idEmpleado": "'. $empleado["nombres"] . ' ' . $empleado["apellidos"] . '",
						"idAlmacen": "' . $almacen["descripcion"] . '",
						"login": "' . $value["login"] . '",
                        "descPerfil": "' . $perfil["descripcion"]. '",
						"ultimo_login": "' . $value["ultimo_login"] . '",
                        "acciones": "' . $acciones . '"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

/*=============================================
Tabla Producto
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaUsuario();
$tabla->mostrarTabla();