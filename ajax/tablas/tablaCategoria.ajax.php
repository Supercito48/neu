<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/categoria.controller.php";
require_once "../../models/categoria.model.php";

require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";


class TablaCategoria
{

	/*=============================================
	Tabla Personas
	=============================================*/

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$categoria = ControllerCategorias::ctrMostrarCategorias(null, null);
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(27, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(28, $idPerfil); 

		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($categoria) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($categoria as $key => $value) {

			$itemProducto= "idCategoria" ;
            $valorProducto = $value["idCategoria"];

            $producto = ControllerProducto::ctrMostrarProducto($itemProducto,$valorProducto);	
			
if(is_array($producto)){
  $productoExiste = $producto['idCategoria'];
}

            /*=============================================
			Estado
			=============================================*/

           

			/*=============================================
			ACCIONES
			=============================================*/

			// $nombre =$value["nomper"];
			if ($permisosedit["acronimo"] == "editcat" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1){
				if($value["estadoCat"] == 0){	
					$estadoCat = "<button class='btn btn-danger btn-sm btnActivar' estadoCat='1' idCategoria='".$value["idCategoria"]."'><i class='fa fa-toggle-off'></i> Desactivado</button>";
				}else{
					$estadoCat = "<button class='btn btn-success btn-sm btnActivar' estadoCat='0'  idCategoria='".$value["idCategoria"]."'><i class='fa fa-toggle-on'></i> Activado</button>";
				}
				
				$editar = "<button class='btn btn-warning editarCategoria' data-toggle='modal' data-target='#modalCategoria' idCategoria='".$value["idCategoria"]."'><i class='fa fa-edit'></i></button>";
			}else{
				$estadoCat = "<button class='btn btn-secondary btn-sm' ><i class='fa fa-ban'></i> sin permisos</button>";
				$editar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

			if ($permisoseli["acronimo"] == "elimcat" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1){
				$eliminar= "<button class='btn btn-danger eliminarCategoria'idCategoria='".$value["idCategoria"]."' idProductoExis='".$productoExiste."'><i class='fa fa-times'></i></button>";
			}else{
				$eliminar = "<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>";
			}

			


		
			$datosJson .= '{
						"idCategoria": "' . ($key + 1) . '",
						"desCat": "' . $value["desCat"] . '",
						"estadoCat": "' . $estadoCat . '",
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
Tabla Categorias
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaCategoria();
$tabla->mostrarTabla();