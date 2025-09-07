<?php

require_once "../controllers/comprobante.controller.php";
require_once "../models/comprobante.model.php";

class ajaxComprobante
{
    public $idDocalmacen ;
	public $idAlmacen;
	public $Documento;
	public $Serie;
	public $Cantidad;

	public function ajaxMostrarComprobantes(){
		$respuesta = ControllerComprobantes::ctrMostrarComprobantes("idDocalmacen ", $_POST["idDocalmacen "]);
		echo json_encode($respuesta);
	}

    public function ajaxMostrarComprobante(){	
		$respuesta = ControllerComprobantes::ctrMostrarComprobante($this->idDocalmacen);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    
    public function registrarComprobantes(){	
		$respuesta = ControllerComprobantes::ctrRegistrarComprobante($this->idAlmacen, $this->Documento, $this->Serie, $this->Cantidad);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxEditarComprobante(){	
		$respuesta = ControllerComprobantes::ctrEditarComprobante($this->idDocalmacen,$this->idAlmacen, $this->Documento, $this->Serie, $this->Cantidad);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

    public function ajaxBorrarComprobante(){	
		$respuesta = ControllerComprobantes::ctrBorrarComprobante($this->idDocalmacen);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

    



}

/*=============================================
Guardar y Editar Persona
=============================================*/

if(isset($_POST["ajaxVerComprobante"])){
    $mostrarCompra = new ajaxComprobante();
    $mostrarCompra -> idDocalmacen = $_POST["idDocalmacen"];
    $mostrarCompra -> ajaxMostrarComprobante();
}


if (isset($_POST["ajaxRegistrar"])) {

    $tipoComprobante = new ajaxComprobante();
    $tipoComprobante->idAlmacen = $_POST["idAlmacen"];
    $tipoComprobante->Documento = $_POST["Documento"];
    $tipoComprobante->Serie = $_POST["Serie"];
    $tipoComprobante->Cantidad = $_POST["Cantidad"];

    $tipoComprobante -> registrarComprobantes();
}

if (isset($_POST["ajaxEditarComprobante"])) {
    $tipoComprobante = new ajaxComprobante();
    $tipoComprobante->idDocalmacen = $_POST["idDocalmacen"];
    $tipoComprobante->idAlmacen = $_POST["idAlmacen"];
    $tipoComprobante->Documento = $_POST["Documento"];
    $tipoComprobante->Serie = $_POST["Serie"];
    $tipoComprobante->Cantidad = $_POST["Cantidad"];
    $tipoComprobante -> ajaxEditarComprobante();
}

if(isset($_POST["ajaxBorrarComprobante"])){
    $mostrarCompra = new ajaxComprobante();
    $mostrarCompra -> idDocalmacen = $_POST["idDocalmacen"];
    $mostrarCompra -> ajaxBorrarComprobante();
}
