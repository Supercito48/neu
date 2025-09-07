<?php

class ControllerProducto{

	/*=============================================
	CREAR Producto
	=============================================*/
	static public function ctrCrearProducto($datos){

		if (
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descProducto"])
		) {

			$tabla = "producto";
			$datos = array(
				"descProducto" => $datos["descProducto"],
				"codigoBarras" => $datos["codigoBarras"],
				"idCategoria" => $datos["idCategoria"],
                "precioCompra" => $datos["precioCompra"],
				"precioVenta" => $datos["precioVenta"],
                "precioVentaMA" => $datos["precioVentaMA"],
                "oferta" => $datos["oferta"]
				
			);

			$respuesta = ModelProducto::mdlIngresarProducto($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	/*=============================================
	MOSTRAR Producto
	=============================================*/

	static public function ctrMostrarProducto($item, $valor){

		$tabla = "producto";

		$respuesta = ModelProducto::mdlMostrarProducto($tabla, $item, $valor);

		return $respuesta;
	
	}
	static public function ctrMostrarProductoDeposito(){

		$respuesta = ModelProducto::mdlMostrarProductoDeposito();

		return $respuesta;
	
	}

	static public function ctrMostrarProductoInventario($idAlmacen){

		$respuesta = ModelProducto::mdlMostrarProductoInventario($idAlmacen);

		return $respuesta;
	
	}
	

	/*=============================================
	MOSTRAR Producto COMPRAS
	=============================================*/

	static public function ctrListarProductoCompra(){

        $producto = ModelProducto::mdlListarProductoCompra();

        return $producto;
    }

	static public function ctrGetDatosProductoCompra($codigo_producto){
        
        $producto = ModelProducto::mdlGetDatosProductoCompra($codigo_producto);
        return $producto;

    }

	/*=============================================
	MOSTRAR Producto Ventas
	=============================================*/

	static public function ctrListarProductos($idAlmacen){

        $producto = ModelProducto::mdlListarProductos($idAlmacen);

        return $producto;
    }

	static public function ctrGetDatosProductos($codigo_producto,$idAlmacen){
        
        $producto = ModelProducto::mdlGetDatosProductos($codigo_producto,$idAlmacen);
        return $producto;

    }

	static public function ctrVerificaStockProducto($codigo_producto,$cantidad_a_comprar, $idAlmacen){

        $respuesta = ModelProducto::mdlVerificaStockProducto($codigo_producto, $cantidad_a_comprar, $idAlmacen);

        return $respuesta;
    }


	/*=============================================
	EDITAR Producto
	=============================================*/

	static public function ctrEditarProducto($datos){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["descProducto"])
			
		){
	

			$tabla = "producto";
			// $tabla = "TipoDocumento";

			$datos = array(
				"idProducto" => $datos["idProducto"],
				"descProducto" => $datos["descProducto"],
				"codigoBarras" => $datos["codigoBarras"],
				"idCategoria" => $datos["idCategoria"],
                "precioCompra" => $datos["precioCompra"],
				"precioVenta" => $datos["precioVenta"],
                "precioVentaMA" => $datos["precioVentaMA"],
                "oferta" => $datos["oferta"]
			);

			$respuesta = ModelProducto::mdlEditarProducto($tabla, $datos);

			return $respuesta;
		} else {

			echo 'Error = No se permiten caracteres especiales en ninguno de los campos';
		}

	}

	static public function ctrEditarPrecio($idProducto,$precioCompra){

        $editarPrecio = ModelProducto::mdlEditarPrecio($idProducto,$precioCompra);

        return $editarPrecio;
    }

	/*=============================================
	BORRAR Producto
	=============================================*/

	static public function ctrBorrarProducto($idProducto){

		$tabla = "producto";
	
		$respuesta = ModelProducto::mdlBorrarProducto($tabla, $idProducto);
		return $respuesta;

		
	}

	//

	static public function ctrMostrarBajosInv($idAlmacen){
		$respuesta = ModelProducto::mdlMostrarBajosInv($idAlmacen);
		return $respuesta;
	}

	static public function ctrMostrarBajosInvD($idAlmacen){
		$respuesta = ModelProducto::mdlMostrarBajosInvD($idAlmacen);
		return $respuesta;
	}

	static public function ctrMostrarMasVendido($idAlmacen){
		$respuesta = ModelProducto::mdlMostrarMasVendido($idAlmacen);
		return $respuesta;
	}

	
	
}