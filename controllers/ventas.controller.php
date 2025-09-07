<?php

class VentasController{

    static public function ctrObtenerNroBoleta($Documento, $idAlmacen){
        
        $nroBoleta = VentasModel::mdlObtenerNroBoleta($Documento, $idAlmacen);

        return $nroBoleta;

    }

    static public function ctrMostrarDocumento($idAlmacen){
        
        $mostrarDocumento = VentasModel::mdlMostrarDocumento($idAlmacen);
        return $mostrarDocumento;

    }

    static public function ctrRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,$serie,$nro_comprobante,$descripcion,$pago_efe,$pago_tar,$pago_credit,$subtotal,$igv,$comision,$delivery,$total_venta,$tipo_pago,$codigo_transa,$contacto,$idCaja){
        
        $productos = VentasModel::mdlRegistrarVenta($datos,$idCliente,$idAlmacen,$idUsuario,$idDocalmacen,$serie,$nro_comprobante,$descripcion,$pago_efe,$pago_tar,$pago_credit,$subtotal,$igv,$comision,$delivery,$total_venta,$tipo_pago,$codigo_transa,$contacto,$idCaja);

        return $productos;

    }

    static public function ctrListarVenta($idVenta){
        $mostrarVenta = VentasModel::mdlListarVenta($idVenta);
        return $mostrarVenta;
    }

    static public function ctrListarVentas($idAlmacen,$fechaDesde, $fechaHasta){

        $ventas = VentasModel::mdlListarVentas($idAlmacen,$fechaDesde,$fechaHasta);
        return $ventas;
    }

    static public function ctrMostrarDetalleVenta($idVenta){
        $mostrarDetalleVentas = VentasModel::mdlMostrarDetalleVenta($idVenta);
        return $mostrarDetalleVentas;
    }
    static public function ctrAnularVenta($idVenta){
        $respuesta = VentasModel:: mdlAnularVenta($idVenta);
        return $respuesta;
    }

   

    static public function ctrTotalVenta($idAlmacen,$fechaDesde,$fechaHasta){
        $respuesta = VentasModel:: mdlTotalVenta($idAlmacen,$fechaDesde,$fechaHasta);
        return $respuesta;
    }



}