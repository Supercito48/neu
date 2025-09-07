<?php

class ControllerCategorias{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCategoria($datos){

		if (
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["desCat"])
		) {

			$tabla = "categoria";

			$datos = array(
				"desCat" => $datos["desCat"],
				"estadoCat" => 1
			);

			$respuesta = ModelCategorias::mdlIngresarCategoria($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "categoria";

		$respuesta = ModelCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarCategoria($datos){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["desCat"])
		){

			$tabla = "categoria";
			// $tabla = "TipoDocumento";

			$datos = array(
				"idCategoria" => $datos["idCategoria"],
				"desCat" => $datos["desCat"]
			);

			$respuesta = ModelCategorias::mdlEditarCategoria($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarCategoria($idCategoria){

		$tabla = "categoria";
	
		$respuesta = ModelCategorias::mdlBorrarCategoria($tabla, $idCategoria);
		return $respuesta;

		
	}
}
