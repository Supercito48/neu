<?php

require_once "../controllers/clientes.controller.php";
require_once "../models/clientes.model.php";

class ajaxClientes
{
    public $idCliente ;
	public $dni;
	public $nombres;
	public $direccion;
	public $telefono;
    public $limite_credito;

	public function ajaxMostrarClientes(){
		$respuesta = ControllerClientes::ctrMostrarClientes("idCliente ", $_POST["idCliente "]);
		echo json_encode($respuesta);
	}

    public function ajaxValidarDni(){

		$item ="dni";
		$valor = $this->dni;

		$respuesta = ControllerClientes::ctrMostrarClientes($item, $valor);
		echo json_encode($respuesta);

	}

     public function ajaxMostrarClienteSelect(){

		$respuesta = ControllerClientes::ctrMostrarClientes(null, null);
		echo json_encode($respuesta);

	}
    public function ajaxMostrarCliente(){	
		$respuesta = ControllerClientes::ctrMostrarCliente($this->idCliente);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    
    public function ajaxctrRegistrarClientes(){	
		$respuesta = ControllerClientes::ctrRegistrarClientes($this->dni, $this->nombres, $this->direccion, $this->telefono,$this->limite_credito);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxEditarClientes(){	
		$respuesta = ControllerClientes::ctrEditarClientes($this->idCliente,$this->dni, $this->nombres, $this->direccion, $this->telefono,$this->limite_credito);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

    public function ajaxBorrarClientes(){	
		$respuesta = ControllerClientes::ctrBorrarClientes($this->idCliente);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	//

	public function ajaxPagarCredito(){	
		$respuesta = ControllerClientes::ctrPagarCredito($this->idCliente,$this->monto,$this->comision, $this->metodo, $this->idCaja,$this->montoComparar);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function ajaxMostrarFechaClient(){	
		$respuesta = ControllerClientes::ctrMostrarFechaClient($this->idCliente);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
	
	public function ajaxMostrarDetalleAbono(){	
		$respuesta = ControllerClientes::ctrMostrarDetalleAbono($this->idCliente);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
	
	

	
}

/*=============================================
Guardar y Editar Persona
=============================================*/

if(isset($_POST["ajaxMostrarCliente"])){
    $mostrarCompra = new ajaxClientes();
    $mostrarCompra -> idCliente = $_POST["idCliente"];
    $mostrarCompra -> ajaxMostrarCliente();
}

if (isset($_POST["ajaxValidarDni"])) {
	
	$leerEmpleado = new ajaxClientes();
	$leerEmpleado -> dni = $_POST["ajaxValidarDni"];
	$leerEmpleado -> ajaxValidarDni();

}

if (isset($_POST["ajaxMostrarClienteSelect"])) {
	
	$leerEmpleado = new ajaxClientes();
	$leerEmpleado -> ajaxMostrarClienteSelect();

}

if (isset($_POST["ajaxRegistrarCliente"])) {

    $tipoComprobante = new ajaxClientes();
    $tipoComprobante->dni = $_POST["dni"];
    $tipoComprobante->nombres = $_POST["nombres"];
    $tipoComprobante->direccion = $_POST["direccion"];
    $tipoComprobante->telefono = $_POST["telefono"];
    $tipoComprobante->limite_credito = $_POST["limite_credito"];

    $tipoComprobante -> ajaxctrRegistrarClientes();
}

if (isset($_POST["ajaxEditarCliente"])) {
    $tipoComprobante = new ajaxClientes();
    $tipoComprobante->idCliente = $_POST["idCliente"];
    $tipoComprobante->dni = $_POST["dni"];
    $tipoComprobante->nombres = $_POST["nombres"];
    $tipoComprobante->direccion = $_POST["direccion"];
    $tipoComprobante->telefono = $_POST["telefono"];
    $tipoComprobante->limite_credito = $_POST["limite_credito"];
    $tipoComprobante -> ajaxEditarClientes();
}

if(isset($_POST["ajaxBorrarCliente"])){
    $mostrarCompra = new ajaxClientes();
    $mostrarCompra -> idCliente = $_POST["idCliente"];
    $mostrarCompra -> ajaxBorrarClientes();
}

//

if (isset($_POST["ajaxPagarCredito"])) {
    $pagocredit = new ajaxClientes();
    $pagocredit->idCliente = $_POST["idCliente"];
    $pagocredit->monto = $_POST["monto"];
	$pagocredit->comision = $_POST["comision"];
    $pagocredit->metodo = $_POST["metodo"];
    $pagocredit->idCaja = $_POST["idCaja"];
	$pagocredit->montoComparar = $_POST["montoComparar"];
    $pagocredit -> ajaxPagarCredito();
}

if(isset($_POST["ajaxMostrarFechaClient"])){
    $clientcret = new ajaxClientes();
    $clientcret -> idCliente = $_POST["idCliente"];
    $clientcret -> ajaxMostrarFechaClient();
}

if(isset($_POST["ajaxMostrarDetalleAbono"])){
    $detabono = new ajaxClientes();
    $detabono -> idCliente = $_POST["idCliente"];
    $detabono -> ajaxMostrarDetalleAbono();
}