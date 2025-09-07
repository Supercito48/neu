<?php

//vamos a requerir el controlador y el modelo
session_start();
require_once "../../controllers/caja.controller.php";
require_once "../../models/caja.model.php";
require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";
require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaCajas
{

	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
        $idAlmacen = $_GET["idAlmacen"];
		$fechaDesde = $_GET["fechaDesde"];
		$fechaHasta = $_GET["fechaHasta"];
	
		$cajas = CajasController::ctrListarCajas($idAlmacen,$fechaDesde,$fechaHasta);

		$permisosing = ControllerPerfil::ctrMostrarMenuPermisos(58, $idPerfil);
		$permisosegr = ControllerPerfil::ctrMostrarMenuPermisos(59, $idPerfil);
		$permisosdet = ControllerPerfil::ctrMostrarMenuPermisos(60, $idPerfil);
		$permisoscerr = ControllerPerfil::ctrMostrarMenuPermisos(61, $idPerfil);

		if (count($cajas) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($cajas as $key => $value) {
			$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

			if ($permisosing["acronimo"] == "ingcaja" && $permisosing["estado"] == "on" && $permisosing["existe"] == 1) {
                $ingreso=  "<a class='dropdown-item btnIngreso' data-toggle='modal' data-target='#mdlGestionarCaja' idCaja='".$value["idCaja"]."'  href='#'>".
							"<i class='fas fa-arrow-right'></i>&nbsp;Ingreso".
							"</a>";
            }else{
                $ingreso=  "";
            }
           
			if ($permisosegr["acronimo"] == "egrcaja" && $permisosegr["estado"] == "on" && $permisosegr["existe"] == 1) {
                $egreso=  "<a class='dropdown-item btnEgreso' data-toggle='modal' data-target='#mdlGestionarCaja' idCaja='".$value["idCaja"]."'  href='#'>".
							"<i class='fas fa-arrow-left'></i>&nbsp;Egreso".
							"</a>";
            }else{
                $egreso=  "";
            }

			if ($permisosdet["acronimo"] == "detcaja" && $permisosdet["estado"] == "on" && $permisosdet["existe"] == 1) {
                $detalle=  "<a class='dropdown-item btnverDetalle'  data-toggle='modal' data-target='#modal_vista' idCaja='".$value["idCaja"]."'  href='#'>".
				"<i class='fas fa-eye'></i>&nbsp;Detalle Mov.".
				"</a>";
            }else{
                $detalle=  "";
            }

			if ($permisoscerr["acronimo"] == "cerracaja" && $permisoscerr["estado"] == "on" && $permisoscerr["existe"] == 1) {
                $cerrarcaja=  "<a class='dropdown-item btnCierre' idCaja='".$value["idCaja"]."'  href='#'>".
				"<i class='fas fa-door-closed'></i>&nbsp;Cerrar caja".
				"</a>";
            }else{
                $cerrarcaja=  "";
            }

			$imprimirr = "<a class='dropdown-item imprimirResumen' idCaja='".$value["idCaja"]."'  href='#'>".
			"<i class='fas fa-print'></i>&nbsp;Imprimir Resumen".
			"</a>";

			
			if($value["estado"] == 0){	
                $estado = "<span class='badge bg-success'>Caja Abierta</span>";
                $acciones = "<div class='btn-group' style='text-align: center;'>".
							"<button style='font-size:13px;' type='button' class='btn btn-success btn-sm dropdown-toggle dropdown-icon' data-toggle='dropdown'>".
								"<i class='fas fa-cog'></i>".
							"</button>".
							"<div class='dropdown-menu'>{$ingreso}{$egreso}{$detalle}{$cerrarcaja}{$imprimirr}".
							"</div>".
							"</div>";
            }else{
				$estado = "<span class='badge bg-danger'>Caja Cerrada</span>";
                $acciones = "<div class='btn-group' style='text-align: center;'>".
							"<button style='font-size:13px;' type='button' class='btn btn-danger btn-sm'>".
							"<i class='fas fa-door-closed'></i> Caja cerrada".
							"</button>".
							"<button style='font-size:13px;' type='button' class='editar btn btn-primary btn-sm imprimirResumen'  idCaja='".$value["idCaja"]."' >".
							"<i class='fas fa-print'></i>".
							"</button>".
							"</div>";
            }

           

         
			$datosJson .= '{
						"idCaja": "' . ($key + 1) . '",
						"fecha_apertura": "' . $value["fecha_apertura"] . '",
						"fecha_cierre": "' . $value["fecha_cierre"] . '",
						"monto_apertura": " '.$configuracion[0]["simbolom"].' ' . number_format($value["monto_apertura"], 2, ',', '.') . '",
                        "monto_ingreso": " '.$configuracion[0]["simbolom"].' ' . number_format($value["monto_ingreso"], 2, ',', '.') . '",
                        "monto_egreso": " '.$configuracion[0]["simbolom"].' ' . number_format($value["monto_egreso"], 2, ',', '.') . '",
                        "monto_cierre": " '.$configuracion[0]["simbolom"].' ' . number_format($value["monto_cierre"], 2, ',', '.') . '",
						"nombres": "'.$value["nombres"].'",
                        "estado": "'.$estado.'",
                        "acciones" : "'.$acciones.'"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .=  ']';

		// }';

		echo $datosJson;
	}
}

$tabla = new TablaCajas();
$tabla->mostrarTabla();