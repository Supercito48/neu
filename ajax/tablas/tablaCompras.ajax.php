<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/compras.controller.php";
require_once "../../models/compras.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaCompras
{

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
		$compras = ComprasController::ctrMostrarCompras($fechaDesde,$fechaHasta);
		$permisosanula = ControllerPerfil::ctrMostrarMenuPermisos(48, $idPerfil);

		//$idCompra = $_GET["idCompra"];, get es para llamar a la tabla..
		//$compras = ComprasController::ctrMostrarCompra($idCompra);


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($compras) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($compras as $key => $value) {

			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
			if ($permisosanula["acronimo"] == "anulcompra" && $permisosanula["estado"] == "on" && $permisosanula["existe"] == 1) {
                $anular=  "<button class='btn btn-danger btnAnularCompra' idCompra='".$value["idCompra"]."'><i class='fa fa-ban'></i></button>";
            }else{
                $anular=  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>" ;
            }
           

			if($value["estado"] == 1){	

                $estado = "<span class='badge bg-danger'>Anulado</span>";
				$acciones = "<div class='btn-group'><button class='btn btn-secondary verCompras' data-toggle='modal' data-target='#modal_vista'  idCompra='".$value["idCompra"]."' ><i class='fa fa-eye'></i></button><button class='btn btn-primary pdf' idCompra='".$value["idCompra"]."'><i class='fa fa-file-pdf'></i></button></div>";

            }else{
				$estado = "<span class='badge bg-green'>Aceptado</span>";
				$acciones = "<div class='btn-group'><button class='btn btn-secondary verCompras' data-toggle='modal' data-target='#modal_vista'  idCompra='".$value["idCompra"]."' ><i class='fa fa-eye'></i></button><button class='btn btn-primary pdf' idCompra='".$value["idCompra"]."'><i class='fa fa-file-pdf'></i></button>{$anular}</div>";

            }
// "total_compra": "S/. ' . number_format($value["total_compra"], 2, ',', '.') . '",
		
			$datosJson .= '{
						"idCompra": "' . ($key + 1) . '",
						"idDocalmacen": "' . $value["idDocalmacen"] . '",
						"serie": "' . $value["serie"] . '",
						"num_documento": "'.$value["num_documento"].'",
                        "nombre": "'.ucwords(strtolower($value["nombre"])).'",
                        "empleado": "'.ucwords($value["empleado"]).'",
                        "tipo_pago": "'.$value["tipo_pago"].'",
				
                        "total_compra":  " '.$configuracion[0]["simbolom"].' ' . number_format($value["total_compra"], 2, ',', '.') . '",
						"estado": "'.$estado.'",
                        "fecha_venta": "'.$value["fecha_venta"].'",
                        "acciones" : "'.$acciones.'"
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
$tabla = new TablaCompras();
$tabla->mostrarTabla();