<?php

require_once "../controllers/caja.controller.php";
require_once "../models/caja.model.php";

class ajaxCajas
{

    public function ajaxVerificarEstadoCaja($idUsuario, $date){
        $estado_caja = CajasController::ctrVerificarEstadoCaja($idUsuario, $date);
        echo json_encode($estado_caja, JSON_UNESCAPED_UNICODE);
    }

    public function ajaxrVercaja(){
        $estado_caja = CajasController::ctrVercaja($this->idUsuario, $this->date);
        echo json_encode($estado_caja, JSON_UNESCAPED_UNICODE);
    }
    

    public function ajaxAperturaCaja(){	
		$respuesta = CajasController::ctrAperturaCaja($this->monto_apertura, $this->idUsuario, $this->idAlmacen);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxCierreCaja(){	
		$respuesta = CajasController::ctrCierreCaja($this->idCaja,$this->monto_ingreso,$this->monto_egreso,$this->monto_cierre);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    
    public function ajaxTotalTodo(){
        $estado_caja = CajasController::ctrTotalTodo($this->idCaja,$this->idUsuario,$this->fecha);
        echo json_encode($estado_caja, JSON_UNESCAPED_UNICODE);
    }
    
    public function ajaxGuardarDetalle(){
        $estado_caja = CajasController::ctrGuardarDetalle($this->idCaja, $this->tipo, $this->descripcion,$this->monto,$this->idUsuario);
        echo json_encode($estado_caja, JSON_UNESCAPED_UNICODE);
    }
    
    public function ajaxMostrarDetalleC(){
        $estado_caja = CajasController::ctrMostrarDetalleC($this->idCaja, $this->tipo,$this->fecha);
        echo json_encode($estado_caja, JSON_UNESCAPED_UNICODE);
    }
    

    


}

/*=============================================
Guardar y Editar Persona
=============================================*/

if (isset($_POST["ajaxAperturaCaja"])) {
    $cajas = new ajaxCajas();
    $cajas->monto_apertura = $_POST["monto_apertura"];
    $cajas->idUsuario = $_POST["idUsuario"];
    $cajas->idAlmacen = $_POST["idAlmacen"];
    $cajas -> ajaxAperturaCaja();
}
if(isset($_POST['ajaxVerificarCaja'])){
    $cajas = new ajaxCajas();
    $cajas -> ajaxVerificarEstadoCaja($_POST['idUsuario'], date('d-m-y'));
}

if(isset($_POST['ajaxrVercaja'])){
    $cajas = new ajaxCajas();
    $cajas->idUsuario = $_POST["idUsuario"];
    $cajas->date = date('d-m-y');
    $cajas -> ajaxrVercaja();
}


if(isset($_POST['ajaxCierreCaja'])){
    $cajas = new ajaxCajas();
    $cajas->idCaja = $_POST["idCaja"];
    $cajas->monto_ingreso = $_POST["monto_ingreso"];
    $cajas->monto_egreso = $_POST["monto_egreso"];
    $cajas->monto_cierre = $_POST["monto_cierre"];
    $cajas -> ajaxCierreCaja();
}

if(isset($_POST['ajaxTotalTodo'])){
    $cajas = new ajaxCajas();
    $cajas->idCaja = $_POST["idCaja"];
    $cajas->idUsuario = $_POST["idUsuario"];
    $cajas->fecha = $_POST["fecha"];
    $cajas -> ajaxTotalTodo();
}

if (isset($_POST["ajaxGuardarDetalle"])) {
    $cajas = new ajaxCajas();
    $cajas->idCaja = $_POST["idCaja"];
    $cajas->tipo = $_POST["tipo"];
    $cajas->descripcion = $_POST["descripcion"]; 
    $cajas->monto = $_POST["monto"];
    $cajas->idUsuario = $_POST["idUsuario"];
    $cajas -> ajaxGuardarDetalle();
}

if (isset($_POST["ajaxMostrarDetalleC"])) {
    $cajas = new ajaxCajas();
    $cajas->idCaja = $_POST["idCaja"];
    $cajas->tipo = $_POST["tipo"];
    $cajas->fecha = $_POST["fecha"];
    
    $cajas -> ajaxMostrarDetalleC();
}
