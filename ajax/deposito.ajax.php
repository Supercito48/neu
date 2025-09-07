<?php

require_once "../controllers/deposito.controller.php";
require_once "../models/deposito.model.php";

class ajaxDeposito
{

    public $idDeposito;
	public $idProducto;
    public $motivo;
    public $idAlmacen;
    public $idUsuario;
    public $stock;
    public $habia;
    
	public function ajaxMostrarDepositos(){
		$respuesta = ControllerDeposito::ctrMostrarDeposito();
		echo json_encode($respuesta);
	}

    public function ajaxMostrarDepositoProducto(){
        $producto = ControllerDeposito::ctrMostrarDepositoProducto($this->idProducto);
        echo json_encode($producto);
    }

    public function ajaxMostrarDepositoU(){
        $deposito = ControllerDeposito::ctrMostrarDepositoU($this->idDeposito);
        echo json_encode($deposito);
    }
   
    public function ajaxEditarSumarStock(){
        $editarDeposito = ControllerDeposito::ctreditarSumaStock($this->idDeposito,$this->stock,$this->idProducto,$this->idUsuario,$this->habia);
        echo json_encode($editarDeposito,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxEditarAjustarStock(){
        $editarDeposito = ControllerDeposito::ctreditarAjustarStock($this->idDeposito,$this->stock,$this->idProducto,$this->idUsuario,$this->habia);
        echo json_encode($editarDeposito,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxEditarTraslado(){
        $editarDeposito = ControllerDeposito::ctreditarTraslado($this->idDeposito,$this->stock,$this->idAlmacen,$this->idProducto,$this->idUsuario,$this->habia,$this->habidst);
        echo json_encode($editarDeposito,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxBorrarDeposito(){
        $borrarDeposito = ControllerDeposito::ctrBorrarDeposito($this->idDeposito,$this->stock,$this->idProducto,$this->idUsuario);
        echo json_encode($borrarDeposito,JSON_UNESCAPED_UNICODE);
    }


    public function ajaxRegistrarDeposito(){	
		$registro = ControllerDeposito::ctrRegistroDeposito($this->idProducto, $this->stock,$this->idUsuario);
		echo json_encode($registro,JSON_UNESCAPED_UNICODE);
	}


}

/*=============================================
Guardar y Editar Persona
=============================================*/

if(isset($_POST["ajaxRegistrarDeposito"])){
    $agregarProducto = new ajaxDeposito();
    $agregarProducto -> idProducto = $_POST["idProducto"];
    $agregarProducto -> stock = $_POST["stock"];
    $agregarProducto -> idUsuario = $_POST["idUsuario"];
    $agregarProducto -> ajaxRegistrarDeposito();
}


if(isset($_POST["ajaxDepositoProducto"])){
    $listaProducto = new ajaxDeposito();
    $listaProducto -> idProducto = $_POST["idProducto"];
    $listaProducto -> ajaxMostrarDepositoProducto();
}

if(isset($_POST["ajaxDepositoU"])){
    $listaProducto = new ajaxDeposito();
    $listaProducto -> idDeposito = $_POST["idDeposito"];
    $listaProducto -> ajaxMostrarDepositoU();
}

if (isset($_POST["ajaxEditarSumarStock"])) {
    $editarDeposito = new ajaxDeposito();
	$editarDeposito->idDeposito = $_POST["idDeposito"];
    $editarDeposito->stock = $_POST["editarstock"];
    $editarDeposito->idProducto = $_POST["idProducto"];
    $editarDeposito->idUsuario = $_POST["idUsuario"];
    $editarDeposito->habia = $_POST["habia"];
    $editarDeposito -> ajaxEditarSumarStock();
}

if (isset($_POST["ajaxEditarAjustarStock"])) {
    $editarDeposito = new ajaxDeposito();
	$editarDeposito->idDeposito = $_POST["idDeposito"];
    $editarDeposito->stock = $_POST["editarstock"];
    $editarDeposito->idProducto = $_POST["idProducto"];
    $editarDeposito->idUsuario = $_POST["idUsuario"];
    $editarDeposito->habia = $_POST["habia"];
    $editarDeposito -> ajaxEditarAjustarStock();
}

if (isset($_POST["ajaxEditarTraslado"])) {
    $editarDeposito = new ajaxDeposito();
	$editarDeposito->idDeposito = $_POST["idDeposito"];
    $editarDeposito->stock = $_POST["editarstock"];
    $editarDeposito->idAlmacen = $_POST["idAlmacen"];
    $editarDeposito->idProducto = $_POST["idProducto"];
    $editarDeposito->idUsuario = $_POST["idUsuario"];
    $editarDeposito->habia = $_POST["habia"];
    $editarDeposito->habidst = $_POST["habidst"];
    $editarDeposito -> ajaxEditarTraslado();
}

if(isset($_POST["ajaxBorrarDeposito"])){
    $borrarDeposito = new ajaxDeposito();
    $borrarDeposito -> idDeposito = $_POST["idDeposito"];
    $borrarDeposito -> stock = $_POST["stock"];
    $borrarDeposito -> idProducto = $_POST["idProducto"];
    $borrarDeposito -> idUsuario = $_POST["idUsuario"];
    $borrarDeposito -> ajaxBorrarDeposito();
}
