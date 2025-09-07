<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/ventas.controller.php";
require_once "../../models/ventas.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaVentas
{

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
        $idAlmacen = $_GET["idAlmacen"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
		$ventas = VentasController::ctrListarVentas($idAlmacen,$fechaDesde, $fechaHasta);
		$permisosanula = ControllerPerfil::ctrMostrarMenuPermisos(51, $idPerfil);
		//$idCompra = $_GET["idCompra"];, get es para llamar a la tabla..
		//$compras = ComprasController::ctrMostrarCompra($idCompra);


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($ventas) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($ventas as $key => $value) {
			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

			if ($permisosanula["acronimo"] == "anulventa" && $permisosanula["estado"] == "on" && $permisosanula["existe"] == 1) {
                $anulaventa=  "<button class='btn btn-danger btnAnularVenta' idVenta='".$value["idVenta"]."'><i class='fa fa-ban'></i></button>";
            }else{
                $anulaventa=  "<button class='btn btn-secondary'><i class='fa fa-ban'></i></button>" ;
            }

			if($value["estado"] == 1){	
                $estado = "<span class='badge bg-danger'>Anulado</span>";
				$acciones = "<div class='btn-group'><button class='btn btn-secondary verVentas' data-toggle='modal' data-target='#modal_vista'  idVenta='".$value["idVenta"]."' ><i class='fa fa-eye'></i></button><button class='btn btn-primary pdf' idVenta='".$value["idVenta"]."'><i class='fa fa-print'></i></button><button class='btn btn-info imprimira4' idVenta='".$value["idVenta"]."'><i class='fas fa-file-pdf'></i></button></div>";
            }else{
				$estado = "<span class='badge bg-green'>Aceptado</span>";
				$acciones = "<div class='btn-group'><button class='btn btn-secondary verVentas' data-toggle='modal' data-target='#modal_vista'  idVenta='".$value["idVenta"]."' ><i class='fa fa-eye'></i></button><button class='btn btn-primary pdf' idVenta='".$value["idVenta"]."'><i class='fa fa-print'></i></button><button class='btn btn-info imprimira4' idVenta='".$value["idVenta"]."'><i class='fas fa-file-pdf'></i></button>{$anulaventa}</div>";
            }

			if($value['pago_efe'] != "0" && $value['pago_tar'] !="0"){

				$metodo_pago = "Mixto"; 

			}else{
				$metodo_pago = $value["tipo_pago"]; 

			}
// "total_compra": "S/. ' . number_format($value["total_compra"], 2, ',', '.') . '",
		
			$datosJson .= '{
						"idVenta": "' . ($key + 1) . '",
						"Documento": "' . $value["Documento"] . '",
						"serie": "' . $value["serie"] . '",
						"nro_comprobante": "'.$value["nro_comprobante"].'",
                        "empleado": "'.ucwords($value["empleado"]).'",
                        "tipo_pago": "'.$metodo_pago.'",
                        "total_venta": " '.$configuracion[0]["simbolom"].' ' . number_format($value["total_venta"], 2, ',', '.') . '",
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
$tabla = new TablaVentas();
$tabla->mostrarTabla();