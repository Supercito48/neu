<?php

require_once "../controllers/ventas.controller.php";
require_once "../models/ventas.model.php";

class AjaxVentas{

    public $idAlmacen;
    public $idUsuario;
    public $idDocalmacen;
    public $serie;
    public $nro_comprobante;
    public $descripcion;
    public $subtotal;
    public $igv;
    public $total_venta;
    public $tipo_pago;
    public $codigo_transa;
    public $contacto;

    public function ajaxObtenerNroBoleta(){

        $nroBoleta = VentasController::ctrObtenerNroBoleta($this->Documento,$this->idAlmacen);
        echo json_encode($nroBoleta,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxMostrarDocumento(){

        $mostrarDocumento = VentasController::ctrMostrarDocumento($this->idAlmacen);
        echo json_encode($mostrarDocumento,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,$serie,$nro_comprobante,$descripcion,$pago_efe,$pago_tar,$pago_credit,$subtotal,
                                        $igv,$comision,$delivery,$total_venta,$tipo_pago,$codigo_transa,$contacto,$idCaja){

        $registroVenta = VentasController::ctrRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,$serie,$nro_comprobante,
                                                                $descripcion,$pago_efe,$pago_tar,$pago_credit,$subtotal,$igv,$comision,$delivery,$total_venta,$tipo_pago,$codigo_transa,$contacto,$idCaja);
        echo json_encode($registroVenta,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxListarVenta(){
        $mostrarVenta = VentasController::ctrListarVenta($this->idVenta);
        echo json_encode($mostrarVenta,JSON_UNESCAPED_UNICODE);
    }

    public function ajaxMostrarDetalleVenta(){

        $mostrarDetalleVenta= VentasController::ctrMostrarDetalleVenta($this->idVenta);
        echo json_encode($mostrarDetalleVenta,JSON_UNESCAPED_UNICODE);

    }
    
    public function ajaxAnularVenta($idVenta){
        $respuesta = VentasController:: ctrAnularVenta($idVenta);
        echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
    }
    public function ajaxTotalVenta(){
        $totalVenta = VentasController::ctrTotalVenta($this->idAlmacen,$this->fechaDesde,$this->fechaHasta);
        echo json_encode($totalVenta,JSON_UNESCAPED_UNICODE);
    }




}
if(isset($_POST["ajaxVerNroBoleta"])){
    $nroBoleta = new AjaxVentas();
    $nroBoleta -> Documento = $_POST["Documento"];
    $nroBoleta -> idAlmacen = $_POST["idAlmacen"];
    $nroBoleta -> ajaxObtenerNroBoleta();
}

if(isset($_POST["ajaxVerDocumento"])){
    $mostrarDocumento = new AjaxVentas();
    $mostrarDocumento -> idAlmacen = $_POST["idAlmacen"];
    $mostrarDocumento -> ajaxMostrarDocumento();
}

if(isset($_POST["ajaxVerVenta"])){
    $mostrarVenta = new AjaxVentas();
    $mostrarVenta -> idVenta = $_POST["idVenta"];
    $mostrarVenta -> ajaxListarVenta();
}

if(isset($_POST["ajaxVerDetalleVenta"])){
    $mostrarVentaD = new AjaxVentas();
    $mostrarVentaD -> idVenta = $_POST["idVenta"];
    $mostrarVentaD -> ajaxMostrarDetalleVenta();
}

if(isset($_POST["ajaxAnularVenta"])){
  
    $ventas = new AjaxVentas();
    $ventas -> ajaxAnularVenta($_POST["idVenta"]);
}
if(isset($_POST["ajaxTotalVenta"])){
    
    $ventas = new AjaxVentas();
    $ventas -> idAlmacen = $_POST["idAlmacen"];
    $ventas -> fechaDesde = $_POST["fechaDesde"];
    $ventas -> fechaHasta = $_POST["fechaHasta"];
    $ventas -> ajaxTotalVenta();

}

if(isset($_POST["arr"])){
     
    $registrar = new AjaxVentas();
    $registrar -> ajaxRegistrarVenta($_POST["arr"],$_POST['idCliente'],$_POST['idAlmacen'],
                                    $_POST['idUsuario'],$_POST['idDocalmacen'],
                                    $_POST['serie'],$_POST['nro_comprobante'],
                                    $_POST['descripcion'],$_POST['pago_efe'],
                                    $_POST['pago_tar'],$_POST['pago_credit'],$_POST['subtotal'],
                                    $_POST['igv'],$_POST['comision'],$_POST['delivery'],$_POST['total_venta'],
                                    $_POST['tipo_pago'],$_POST['codigo_transa'],
                                    $_POST['contacto'],$_POST['idCaja']);

 }