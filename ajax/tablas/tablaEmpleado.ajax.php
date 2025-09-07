<?php

//vamos a requerir el controlador y el modelo

require_once "../../controllers/empleado.controller.php";
require_once "../../models/empleado.model.php";

class TablaEmpleado
{

	/*=============================================
	Tabla Personas
	=============================================*/

	public function mostrarTabla()
	{
		//creamos el objeto personas que solicitara al controlador la información de la tabla personas
		$Empleado = ControllerEmpleado::ctrMostrarEmpleado(null, null);
		//Si la tabla viene vacia entonces retornamos los datos JSON con la structura vacia
		if (count($Empleado) == 0) {

			$datosJson = '[]';

			// $datosJson = '{"data": []}';
			echo $datosJson;

			return;
		}

		$datosJson = '[';
		// "data": [ ';

		foreach ($Empleado as $key => $value) {
          

			/*=============================================
			ACCIONES
			=============================================*/

			
			if ($value["foto"] != "views/img/Empleado/default/avatar4.png"){
				$acciones= "<div class='btn-group'><button class='btn btn-warning editarEmpleado' data-toggle='modal' data-target='#modalEditarEmpleado' id='".$value["idEmpleado"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarEmpleado' idEliminar='".$value["idEmpleado"]."' fotoEliminar ='".$value["foto"]."'><i class='fa fa-times'></i></button></div>";
			}else{
				$acciones= "<div class='btn-group'><button class='btn btn-warning editarEmpleado' data-toggle='modal' data-target='#modalEditarEmpleado' id='".$value["idEmpleado"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarEmpleado' idEliminar='".$value["idEmpleado"]."' fotoEliminar =''><i class='fa fa-times'></i></button></div>";
			}
			
			// $nombre =$value["nomper"];
			$foto = "<img src='" . $value["foto"] . "' width='40px'>";
			//$acciones = "<div class='btn-group'><button class='btn btn-warning editarEmpleado' data-toggle='modal' data-target='#modalEditarEmpleado' id='".$value["idEmpleado"]."'><i class='fa fa-edit'></i></button><button class='btn btn-danger eliminarEmpleado' idEliminar='".$value["idEmpleado"]."' fotoEliminar ='".$value["foto"]."'><i class='fa fa-times'></i></button></div>";

			$datosJson .= '{
						"idEmpleado": "' . ($key + 1) . '",
						"nombres": "' . $value["nombres"] . '",
						"apellidos": "' . $value["apellidos"] . '",
						"telefono": "' . $value["telefono"] . '",
						"direccion": "' . $value["direccion"] . '",
						"dni": "' . $value["dni"] . '",
						"correo": "' . $value["correo"] . '",
						"fecNacimiento": "' . $value["fecNacimiento"] . '",
						"foto": "' . $foto . '",
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
$tabla = new TablaEmpleado();
$tabla->mostrarTabla();