<?php

class ControllerKardex{

	static public function VerProductosKardex($item, $valor, $item2, $valor2){

		$tabla = "kardex";
		$resultado = ModelKardex::VerProductosKardex($tabla, $item, $valor, $item2, $valor2);
		return $resultado;

	}

	static public function ctrVerKardex($idAlmacen, $fechaDesde, $fechaHasta){
		$resultado = ModelKardex::mdlVerKardex($idAlmacen, $fechaDesde, $fechaHasta);
		return $resultado;
	}
	

	static public function ctrCrearKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {

			
			$hay =  0 + $datos["stock"];
			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Registro Inicial",
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Entrada",
				"estado" => 1,
				"habia" => 0,
				"hay" => $hay,
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrAumentoKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {


			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Aumento de stock",
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Entrada",
				"estado" => 1,
				"habia" => $datos["habia"],
				"hay" => $datos["hay"],
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrAjusteKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {


			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Ajuste general",
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Ajuste",
				"estado" => 1,
				"habia" => $datos["habia"],
				"hay" => $datos["hay"],
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrSalidaTKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {

//aqui seria lo ideal que cuando envie le salga a que almacen enviara, eso tratar de hcerlo
			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Traslado enviado a "." ".$datos["destinodesc"],
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Salida",
				"estado" => 1,
				"habia" => $datos["habia"],
				"hay" => $datos["hay"],
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrEntradaTKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {


			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Traslado enviado de "." ". $datos["destinodesc"],
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Entrada",
				"estado" => 1,
				"habia" => $datos["habia"],
				"hay" => $datos["hay"],
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrEliminarInventarioKardex($datos){

		if (
			preg_match('/^[0-9]+$/', $datos["stock"])
		) {


			$tabla = "kardex";
			$datos = array(
		
				"motivo" => "Elimianado de inventario",
				"stock" => $datos["stock"],
                "idProducto" => $datos["idProducto"],
				"idAlmacen" => $datos["idAlmacen"],
				"idUsuario" => $datos["idUsuario"],
				"tipo" => "Eliminado",
				"estado" => 1,
				"habia" => $datos["stock"],
				"hay" => 0,
				
			);

			$respuesta = ModelKardex::mdlIngresarKardex($tabla, $datos);

			return $respuesta;
		
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	
}

    

/*UPDATE inventario SET stock = 12-3  WHERE idAlmacen = 21 AND idProducto = 1 ;
UPDATE inventario SET stock = 33+3  WHERE idAlmacen = 1 AND idProducto = 1*/