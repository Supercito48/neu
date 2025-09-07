<?php

class CajasController{

    
    static public function ctrVerificarEstadoCaja($idUsuario, $date){
        $cajas = CajasModel::mdlVerificarEstadoCaja($idUsuario, $date);
        return $cajas;
    }

    static public function ctrVercaja($idUsuario, $date){
        $cajas = CajasModel:: mdlVercaja($idUsuario, $date);
        return $cajas;
    }
   

    static public function ctrListarCajas($idAlmacen,$fechaDesde,$fechaHasta){
        $cajas = CajasModel::mdlListarCajas($idAlmacen,$fechaDesde,$fechaHasta);
        return $cajas;
    }

    static public function ctrAperturaCaja($monto_apertura, $idUsuario, $idAlmacen){
        $cajas = CajasModel::mdlAperturaCaja($monto_apertura, $idUsuario, $idAlmacen);
        return $cajas;
    }

    static public function ctrCierreCaja($idCaja,$monto_ingreso,$monto_egreso,$monto_cierre){
        $cajas = CajasModel::mdlCierreCaja($idCaja,$monto_ingreso,$monto_egreso,$monto_cierre);
        return $cajas;
    }

    static public function ctrTotalTodo($idCaja,$idUsuario,$fecha){
        $cajas = CajasModel::mdlTotalTodo($idCaja,$idUsuario,$fecha);
        return $cajas;
    }

    static public function ctrGuardarDetalle($idCaja, $tipo, $descripcion,$monto,$idUsuario){
        $cajas = CajasModel::mdlGuardarDetalle($idCaja, $tipo, $descripcion,$monto,$idUsuario);
        return $cajas;
    }

    static public function ctrMostrarDetalleC($idCaja, $tipo,$fecha){
        $cajas = CajasModel::mdlMostrarDetalleC($idCaja, $tipo,$fecha);
        return $cajas;
    }
    
    
    
    
   
    
}