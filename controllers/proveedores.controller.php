<?php

class ControllerProveedores{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearProveedores($datos){

        if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["RUC"])
            ) {
                $tabla = "proveedores";
                $datos = array(
                    "RUC" => $datos["RUC"],
                    "nombre" => $datos["nombre"],
                    "direccion" => $datos["direccion"],
                    "celular" => $datos["celular"],
                    "telefono" => $datos["telefono"],
                    "email" => $datos["email"],
                );

                $respuesta = ModelProveedores::mdlIngresarProveedores($tabla, $datos);

                return $respuesta;
            } else {
                echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
            }
        
	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarProveedores($item, $valor){

		$tabla = "proveedores";

		$respuesta = ModelProveedores::mdlMostrarProvedores($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarProveedores($datos){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["RUC"])
		){

			$tabla = "proveedores";
			// $tabla = "TipoDocumento";

			$datos = array(
				"idProveedor" => $datos["idProveedor"],
                "RUC" => $datos["RUC"],
                "nombre" => $datos["nombre"],
                "direccion" => $datos["direccion"],
                "celular" => $datos["celular"],
                "telefono" => $datos["telefono"],
                "email" => $datos["email"],
			);

			$respuesta = ModelProveedores::mdlEditarProveedores($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarProveedores($idProveedor){

		$tabla = "proveedores";
	
		$respuesta = ModelProveedores::mdlBorrarProveedores($tabla, $idProveedor);
		return $respuesta;

		
	}
}