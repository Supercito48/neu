<?php

class ControllerClientes{

	static public function ctrMostrarClientes($item, $valor){
		$respuesta = ModelClientes::mdlMostrarClientes($item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarCliente($idCliente){
		$respuesta = ModelClientes::mdlMostrarCliente($idCliente);
		return $respuesta;
	}
    static public function ctrRegistrarClientes($dni, $nombres, $direccion, $telefono, $limite_credito){
		$respuesta = ModelClientes::mdlRegistrarClientes($dni, $nombres, $direccion, $telefono, $limite_credito);
		return $respuesta;
	}
	static public function ctrEditarClientes($idCliente,$dni, $nombres, $direccion, $telefono, $limite_credito){
		$respuesta = ModelClientes::mdlEditarClientes($idCliente,$dni, $nombres, $direccion, $telefono, $limite_credito);
		return $respuesta;
	}
	static public function ctrBorrarClientes($idCliente){
		$respuesta = ModelClientes::mdlBorrarClientes($idCliente);
		return $respuesta;
	}

	//

	static public function ctrPagarCredito($idCliente, $monto,$comision, $metodo, $idCaja,$montoComparar){
		$respuesta = ModelClientes::mdlPagarCredito($idCliente, $monto,$comision, $metodo, $idCaja,$montoComparar);
		return $respuesta;
	}

	static public function ctrMostrarFechaClient($idCliente){
		$respuesta = ModelClientes::mdlMostrarFechaClient($idCliente);
		return $respuesta;
	}

	static public function ctrMostrarDetalleClient($idVenta){
		$respuesta = ModelClientes::mdlMostrarDetalleClient($idVenta);
		return $respuesta;
	}

	static public function ctrMostrarDetalleAbono($idCliente){
		$respuesta = ModelClientes::mdlMostrarDetalleAbono($idCliente);
		return $respuesta;
	}

	

	
}