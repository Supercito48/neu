<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/inventario.controller.php";
require_once "../../models/inventario.model.php";

require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

class TablaInventario
{

	/*=============================================
	Tabla Inventario
	=============================================*/

	
	public function mostrarTabla()
	{

		$idPerfil = $_SESSION["idPerfil"];
		$idAlmacen = $_GET["idAlmacen"];
		
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$Inventario = ControllerInventario::ctrVerInventario($idAlmacen);

		$permisossum = ControllerPerfil::ctrMostrarMenuPermisos(35, $idPerfil);
		$permisosajus = ControllerPerfil::ctrMostrarMenuPermisos(36, $idPerfil);
		$permisostras = ControllerPerfil::ctrMostrarMenuPermisos(37, $idPerfil);
		$permisoselim = ControllerPerfil::ctrMostrarMenuPermisos(38, $idPerfil);

		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($Inventario) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';
		
		foreach ($Inventario as $key => $value) {


			if ($permisossum["acronimo"] == "suminv" && $permisossum["estado"] == "on" && $permisossum["existe"] == 1) {

                $aumentar=  "<span class='text-primary px-1 btnSumaStock' idInventario='". $value['idInventario']."' style='cursor: pointer;' data-toggle='modal' data-target='#modalAumentoInventario'>".
							"<i class='fas fa-plus-circle fa-2x'></i>".
							"</span>" ;
            }else{
                $aumentar=  "<span class='text-secondary px-1'>" .
                            "<i class='fas fa-plus-circle fa-2x'></i>" .
                            "</span>" ;
            }
           
            if ($permisosajus["acronimo"] == "ajusinv" && $permisosajus["estado"] == "on" && $permisosajus["existe"] == 1) {

                $ajustar=   "<span class='text-warning px-1 btnSumaStock' idInventario='". $value['idInventario']."' style='cursor: pointer;' data-toggle='modal' data-target='#modalAjustarInventario'>".	
							"<i class='fas fa-sync fa-2x'></i>".
							"</span>" ;
            }else{
                $ajustar=   "<span class='text-secondary px-1' >" .
                            "<i class='fas fa-sync fa-2x'></i>" .
                            "</span>" ;
            }

            if ($permisostras["acronimo"] == "trasinv" && $permisostras["estado"] == "on" && $permisostras["existe"] == 1) {

                $traslado=  "<span class='text-orange px-1 btnSumaStock' style='cursor: pointer;' idInventario='". $value['idInventario']."' data-toggle='modal' data-target='#modalTraslado'>".
							"<i class='fas fa-truck fa-2x'></i>".
							"</span>" ;
            }else{
                $traslado=  "<span class='text-secondary px-1' >" .
                            "<i class='fas fa-truck fa-2x'></i>" .
                            "</span>" ;
            }
           
            if ($permisoselim["acronimo"] == "eliminv" && $permisoselim["estado"] == "on" && $permisoselim["existe"] == 1) {

                $eliminar=  "<span class='text-danger px-1 eliminarInventario' style='cursor: pointer;' idInventario='" . $value['idInventario'] . "' stock='" . $value['stock'] . "' idProducto='" . $value['idProducto'] . "' idAlmacen='" . $value['idAlmacen'] . "' idUsuario='" . $_SESSION["idUsuario"] . "'>" .
                            "<i class='fas fa-trash fa-2x'></i>" .
                            "</span>";
            }else{
                $eliminar=  "<span class='text-secondary px-1'>" .
                            "<i class='fas fa-trash fa-2x'></i>" .
                            "</span>";
            }

			
			$acciones = "{$aumentar}{$ajustar}{$traslado}{$eliminar}";

			if($value["stock"]<=5){
				$stock = "<button class='btn btn-danger'> ". $value["stock"]. "</button>";
			}else if($value["stock"]<10){
				$stock = "<button class='btn btn-warning'> ". $value["stock"]. "</button>";
			}else{
				$stock = "<button class='btn btn-success'> ". $value["stock"]. "</button>";
			}

			$stock_minimo = "<button class='btn btn-danger'> ". $value["stock_minimo"]. "</button>";

			$datosJson .= '{
						"codigoBarras": "' .  $value["codigoBarras"]. '",
						"descProducto": "' . $value["descProducto"] . '",
						"desCat": "' . $value["desCat"] . '",
                        "stock": " ' . $stock. '",
						"stock_minimo": " ' . $stock_minimo . '",
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
Tabla Inventario
=============================================*/
//con esto ejecutamos el metodo.
$tabla = new TablaInventario();
$tabla->mostrarTabla();