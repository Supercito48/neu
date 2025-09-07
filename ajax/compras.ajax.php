<?php

require_once "../controllers/compras.controller.php";
require_once "../models/compras.model.php";

class AjaxCompras{

    public $idProveedor;
    public $idUsuario;
    public $idDocalmacen;
    public $serie;
    public $num_documento;
    public $descripcion;
    public $subtotal;
    public $igv;
    public $total_compra;
    public $tipo_pago;
    public $codigo_transa;
    public $contacto;



    public function ajaxRegistrarCompra($datos, $idProveedor, $idUsuario, $idDocalmacen, $num_documento, $serie, $subtotal, $igv, $total_compra,$tipo_pago,$codigo_transa,$contacto){

        $registroCompra = ComprasController::ctrRegistrarCompra($datos, $idProveedor, $idUsuario, $idDocalmacen, $num_documento, $serie, $subtotal, $igv, $total_compra,$tipo_pago,$codigo_transa,$contacto);
        echo json_encode($registroCompra,JSON_UNESCAPED_UNICODE);

    }
    public function ajaxMostrarProovedor(){

        $mostrarProveedor = ComprasController::ctrMostrarProveedor();
        echo json_encode($mostrarProveedor,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxMostrarCompra(){

        $mostrarCompra = ComprasController::ctrMostrarCompra($this->idCompra);
        echo json_encode($mostrarCompra,JSON_UNESCAPED_UNICODE);

    }

    /*public function ajaxMostrarCompras(){

        $mostrarCompras = ComprasController::ctrMostrarCompras();
        echo json_encode($mostrarCompras,JSON_UNESCAPED_UNICODE);

    }*/


    public function ajaxMostrarDetalleCompra(){

        $mostrarDetalleCompra = ComprasController::ctrMostrarDetalleCompra($this->idCompra);
        echo json_encode($mostrarDetalleCompra,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxAnularCompra($idCompra){

        $respuesta = ComprasController:: ctrAnularCompra($idCompra);
        echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxTotalCompra(){

        $totalCompra = ComprasController::ctrTotalCompra($this->fechaDesde,$this->fechaHasta);
        echo json_encode($totalCompra,JSON_UNESCAPED_UNICODE);

    }
 
  
}

if(isset($_POST["ajaxVerProveedor"])){
    $mostrarProveedor = new AjaxCompras();
    $mostrarProveedor -> ajaxMostrarProovedor();
}

if(isset($_POST["ajaxVerCompra"])){
    $mostrarCompra = new AjaxCompras();
    $mostrarCompra -> idCompra = $_POST["idCompra"];
    $mostrarCompra -> ajaxMostrarCompra();
}

/*if(isset($_POST["ajaxVerCompras"])){
    $mostrarCompra = new AjaxCompras();
    $mostrarCompra -> ajaxMostrarCompras();
}*/

if(isset($_POST["ajaxVerDetalleCompra"])){
    $mostrarCompraD = new AjaxCompras();
    $mostrarCompraD -> idCompra = $_POST["idCompra"];
    $mostrarCompraD -> ajaxMostrarDetalleCompra();
}

if(isset($_POST["ajaxAnularCompra"])){
  
    $compras = new AjaxCompras();
    $compras -> ajaxAnularCompra($_POST["idCompra"]);
}

if(isset($_POST["ajaxTotalCompra"])){
    $totalCompra = new AjaxCompras();
    $totalCompra -> fechaDesde = $_POST["fechaDesde"];
    $totalCompra -> fechaHasta = $_POST["fechaHasta"];
    $totalCompra -> ajaxTotalCompra();
}


if(isset($_POST["arr"])){
     
    $registrar = new AjaxCompras();
    $registrar -> ajaxRegistrarCompra($_POST["arr"],$_POST['idProveedor'],
                                    $_POST['idUsuario'],$_POST['idDocalmacen'],
                                    $_POST['num_documento'],$_POST['serie'],
                                    $_POST['subtotal'], $_POST['igv'],$_POST['total_compra'],
                                    $_POST['tipo_pago'],$_POST['codigo_transa'],
                                    $_POST['contacto']);

 }