<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/kardex.controller.php";
require_once "../../models/kardex.model.php";

class TablaKardex
{

	/*=============================================
	Tabla Producto
	=============================================*/

	public function mostrarTabla()
	{

        $idAlmacen = $_GET["idAlmacen"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
		$kardex = ControllerKardex::ctrVerKardex($idAlmacen, $fechaDesde, $fechaHasta);
		
		if (count($kardex) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';
		
		foreach ($kardex as $key => $value) {

            if ($value["tipo"]=="Entrada"){
                $tipo = "<button style='pointer-events: none;' type='button' class='btn btn-success btn-block'> Entrada <i class='fas fa-hand-point-right'></i></button>";
            }elseif ($value["tipo"]=="Eliminado"){
                $tipo = "<button style='pointer-events: none;' type='button' class='btn btn-danger btn-block'> Eliminado <i class='fas fa-ban'></i></button>";
            } elseif ($value["tipo"]=="Ajuste") {
                $tipo = "<button style='pointer-events: none;' type='button' class='btn btn-warning btn-block'> Ajuste <i class='fas fa-sync'></i></button>";
            } else {
                $tipo = "<button style='pointer-events: none;' type='button' class='btn btn-danger btn-block'> Salida <i class='fas fa-hand-point-left'></i></button>";
            }
            
			$datosJson .= '{
						
						"fecha_registro": "' . $value["fecha_registro"] . '",
						"descProducto": "' . $value["descProducto"] . '",
                        "motivo": "' . $value["motivo"] . '",
						"tipo": "' . $tipo . '",
                        "habia": "' . number_format($value["habia"], 2, '.', ',') . '",
                        "stock": "' . number_format($value["stock"], 2, '.', ',') . '",
                        "hay": "' . number_format($value["hay"], 2, '.', ',') . '",
						"empleado" : "' . $value["empleado"] . '"
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
$tabla = new TablaKardex();
$tabla->mostrarTabla();
