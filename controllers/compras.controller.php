<?php

class ComprasController{

    static public function ctrRegistrarCompra($datos, $idProveedor, $idUsuario, $idDocalmacen, $num_documento, $serie, $subtotal, $igv, $total_compra,$tipo_pago,$codigo_transa,$contacto){
        $productos = ComprasModel::mdlRegistrarCompra($datos, $idProveedor, $idUsuario, $idDocalmacen, $num_documento, $serie, $subtotal, $igv, $total_compra,$tipo_pago,$codigo_transa,$contacto);
        return $productos;
    }
    static public function ctrMostrarProveedor(){
        $mostrarProovedor = ComprasModel::mdlMostrarProovedor();
        return $mostrarProovedor;
    }

   /* static public function ctrMostrarCompra($idCompra){
        $mostrarCompras = ComprasModel::mdlMostrarCompra($idCompra);
        return $mostrarCompras;
    }*/

   

    static public function ctrMostrarCompras($fechaDesde,$fechaHasta){
        $mostrarCompras = ComprasModel::mdlMostrarCompras($fechaDesde,$fechaHasta);
        return $mostrarCompras;
    }
    static public function ctrMostrarCompra($idCompra){
        $mostrarCompra = ComprasModel::mdlMostrarCompra($idCompra);
        return $mostrarCompra;
    }

    /*

    */
    static public function ctrMostrarDetalleCompra($idCompra){
        $mostrarDetalleCompras = ComprasModel::mdlMostrarDetalleCompra($idCompra);
        return $mostrarDetalleCompras;
    }

    static public function ctrAnularCompra($idCompra){
        $respuesta = ComprasModel::mdlAnularCompra($idCompra);
        return $respuesta;
    }

    static public function ctrTotalCompra($fechaDesde,$fechaHasta){
        $respuesta = ComprasModel:: mdlTotalCompra($fechaDesde,$fechaHasta);
        return $respuesta;
    }

    

    
}