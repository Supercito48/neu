<?php

require_once "../controllers/configuracion.controller.php";
require_once "../models/configuracion.model.php";

class ajaxConfiguracion
{
   
	public function ajaxMostrarConfiguracion(){	
		$respuesta = ControllerConfiguracion::ctrMostrarConfiguracion();
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
	
    public function ajaxEditarEmpresa(){	
		$respuesta = ControllerConfiguracion::ctrEditarEmpresa($this->idEmpresa, $this->logo, $this->ruc, $this->razon_social, $this->direccion, $this->email,$this->moneda,$this->simbolom,$this->impuesto,$this->antiguoLogo);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
	
	
}


if(isset($_POST["ajaxMostrarConfiguracion"])){
    $configuracion = new ajaxConfiguracion();
    $configuracion -> ajaxMostrarConfiguracion();
}

if(isset($_POST["ajaxEditarEmpresa"])){
    $configuracion = new ajaxConfiguracion();
    $configuracion -> idEmpresa = $_POST["idEmpresa"];

    if(isset($_FILES["logo"])){
		$configuracion -> logo = $_FILES["logo"];
	}else{
		$configuracion -> logo = null;
	}	

    $configuracion -> ruc = $_POST["ruc"];
    $configuracion -> razon_social = $_POST["razon_social"];
    $configuracion -> direccion = $_POST["direccion"];
    $configuracion -> email = $_POST["email"];
    $configuracion -> moneda = $_POST["moneda"];
    $configuracion -> simbolom = $_POST["simbolom"];
    $configuracion -> impuesto = $_POST["impuesto"];
	$configuracion -> antiguoLogo = $_POST["antiguoLogo"];
    $configuracion -> ajaxEditarEmpresa();
}