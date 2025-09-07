<?php

//vamos a requerir el controlador y el modelo

require_once "../../controllers/tipopago.controller.php";
require_once "../../models/tipopago.model.php";

class TablaTipopago
{

	/*=============================================
	Tabla Tipopago
	=============================================*/

	public function mostrarTabla()
	{

		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$tipopago = ControllerTipopago::ctrMostrarTipopago(null, null,null);


		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($tipopago) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($tipopago as $key => $value) {

       

			/*=============================================
			ACCIONES
			=============================================*/

			// $nombre =$value["nomper"];
			$editar = "<button class='btn btn-warning'><i class='fa fa-edit'></i></button>";
            $eliminar= "<button class='btn btn-danger'><i class='fa fa-times'></i></button>";

		
			$datosJson .= '{
						"idPago": "' . ($key + 1) . '",
						"descPago": "' . $value["descPago"] . '",
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
$tabla = new TablaTipopago();
$tabla->mostrarTabla();