<?php
class ControllerInventario{

	static public function VerProductosInventario($item, $valor, $item2, $valor2){

		$tabla = "inventario";
		$respuesta = ModelInventario::VerProductosInventarioM($tabla, $item, $valor, $item2, $valor2);
		return $respuesta;

	}

	static public function ctrVerInventario($idAlmacen){
		$respuesta = ModelInventario::mdlVerInventario($idAlmacen);
		return $respuesta;
	}

	static public function ctrTotalInventario($idAlmacen){
		$respuesta = ModelInventario::mdlTotalInventario($idAlmacen);
		return $respuesta;
	}
	

	static public function ctrTraslado($item11, $valor11, $item22, $valor22){

		$tabla = "inventario";
		$respuesta = ModelInventario::mdlTraslado($tabla, $item11, $valor11, $item22, $valor22);
		return $respuesta;

	}

		/*=============================================
	CREAR Inventario
	=============================================*/
	static public function ctrCrearInventario($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {

			$tabla = "inventario";
			$datos = array(
		
				"idAlmacen" => $datos["idAlmacen"],
				"idProducto" => $datos["idProducto"],
                "stock" => $datos["stock"],
				"stock_minimo" => $datos["stock_minimo"],
				"idUsuario" => $datos["idUsuario"],
               
			);

			$respuesta = ModelInventario::mdlIngresarInventario($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	MOSTRAR Inventario
	=============================================*/

	static public function ctrMostrarInventario($item, $valor){

		$tabla = "inventario";

		$respuesta = ModelInventario::mdlMostrarInventario($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR Inventario
	=============================================*/

	static public function ctrEditarInventario($datos){

		if(
			preg_match('/^[0-9]+$/', $datos["stock"])
			
		){
			$tabla = "inventario";
			$datos = array(
				"idInventario" => $datos["idInventario"],
                "stock" => $datos["stock"]
			);

			$respuesta = ModelInventario::mdlEditarStock($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	TRASLADO  Inventario
	=============================================*/

	static public function ctrTrasladoInventario($datos){

		if(
			preg_match('/^[0-9]+$/', $datos["stock"])
			
		){
			$tabla = "inventario";
			$datos = array(
				"idAlmacen" => $datos["idAlmacen"],
				"idProducto" => $datos["idProducto"],
                "stock" => $datos["stock"]
			);

			$respuesta = ModelInventario::mdlTrasladoStock($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	BORRAR Inventario
	=============================================*/

	static public function ctrBorrarInventario($idInventario){

		$tabla = "inventario";
	
		$respuesta = ModelInventario::mdlBorrarInventario($tabla, $idInventario);
		return $respuesta;

		
	}
}

    