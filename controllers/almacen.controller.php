<?php

class ControllerAlmacen{

	/*=============================================
	CREAR ALMACEN
	=============================================*/
	static public function ctrCrearAlmacen($datos){

		if (
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])
		) {

			$tabla = "almacen";
			$datos = array(
				"descripcion" => $datos["descripcion"],
				"ubicacion" => $datos["ubicacion"],
				"entrada" =>$datos["entrada"],
				"salida" =>$datos["salida"],
				"estado" => 1
			);

			$respuesta = ModelAlmacen::mdlIngresarAlmacen($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	MOSTRAR ALMACEN
	=============================================*/

	static public function ctrMostrarAlmacen($item, $valor){

		$tabla = "almacen";

		$respuesta = ModelAlmacen::mdlMostrarAlmacen($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR ALMACEN
	=============================================*/

	static public function ctrEditarAlmacen($datos){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descripcion"])
			
		){
	

			$tabla = "almacen";
			// $tabla = "TipoDocumento";

			$datos = array(
				"idAlmacen" => $datos["idAlmacen"],
				"descripcion" => $datos["descripcion"],
				"ubicacion" => $datos["ubicacion"],
				"entrada" =>$datos["entrada"],
				"salida" =>$datos["salida"]
			);

			$respuesta = ModelAlmacen::mdlEditarAlmacen($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	BORRAR ALMACEN
	=============================================*/

	static public function ctrBorrarAlmacen($idAlmacen){

		$tabla = "almacen";
	
		$respuesta = ModelAlmacen::mdlBorrarAlmacen($tabla, $idAlmacen);
		return $respuesta;

		
	}
}