<?php

class ControllerComprobantes{

	static public function ctrMostrarComprobantes($idAlmacen, $valor){
		$respuesta = ModelComprobante::mdlMostrarComprobantes($idAlmacen, $valor);
		return $respuesta;
	}

	static public function ctrMostrarComprobante($idDocalmacen){
		$respuesta = ModelComprobante::mdlMostrarComprobante($idDocalmacen);
		return $respuesta;
	}
	

    static public function ctrRegistrarComprobante($idAlmacen, $Documento, $Serie, $Cantidad){
		$respuesta = ModelComprobante::mdlRegistrarComprobante($idAlmacen, $Documento, $Serie, $Cantidad);
		return $respuesta;
	}

	static public function ctrEditarComprobante($idDocalmacen,$idAlmacen, $Documento, $Serie, $Cantidad){
		$respuesta = ModelComprobante::mdlEditarComprobante($idDocalmacen,$idAlmacen, $Documento, $Serie, $Cantidad);
		return $respuesta;
	}

	static public function ctrBorrarComprobante($idDocalmacen){
		$respuesta = ModelComprobante::mdlBorrarComprobante($idDocalmacen);
		return $respuesta;
	}

	
}
