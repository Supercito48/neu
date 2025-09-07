<?php

require_once "conexion.php";
date_default_timezone_set("America/Lima");


class CajasModel{

    static public function mdlVerificarEstadoCaja($idUsuario, $date){
//verificar para poder abrir otra caja, si esta en count 1 no dejara arbir otra caja al mismo usuario con la misma fecha
//acomplar si le falta el id almacen,
                                            /*SELECT * FROM caja 
                                                WHERE idUsuario = 1 
                                                AND estado = 0
                                                AND idAlmacen = 999
                                                AND DATE(fecha_apertura) >= date('2022-06-23')*/
        $stmt = Conexion::conectar()->prepare("SELECT count(*) FROM caja 
                                                WHERE idUsuario = :idUsuario 
                                                AND estado = 0
                                                AND DATE_FORMAT(fecha_apertura, '%d-%m-%y') = :fecha_apertura");

        $stmt -> bindParam(":idUsuario",$idUsuario,PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_apertura",$date,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlVercaja($idUsuario, $date){


        /*PARA TRAER LA CAJA DEBE SER DE ACUERDO AL USUARIO, FECHA Y ESTADO
                                                    SI LA CAJA ESTA ABIERTA QUE ME TRAIGA SI NO QUE LO TRAIGA NULO
                                                    select * from caja
                                                    WHERE idUsuario = 1
                                                    AND estado = 0
                                                    AND DATE_FORMAT(fecha_apertura, '%d-%m-%y') = DATE_FORMAT(SYSDATE(), '%d-%m-%y')*/

        $stmt = Conexion::conectar()->prepare("SELECT * FROM caja 
                                                WHERE idUsuario = :idUsuario 
                                                AND estado = 0
                                                AND DATE_FORMAT(fecha_apertura, '%d-%m-%y') = :fecha_apertura");

        $stmt -> bindParam(":idUsuario",$idUsuario,PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_apertura",$date,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlListarCajas($idAlmacen,$fechaDesde,$fechaHasta){

        try {

            $stmt = Conexion::conectar()->prepare("SELECT c.*, em.* FROM caja c 
                                                    INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                    INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                    WHERE c.idAlmacen =  :idAlmacen
                                                    AND DATE(c.fecha_apertura) >= date(:fechaDesde) and DATE(c.fecha_apertura) <= date(:fechaHasta)");

            $stmt -> bindParam(":idAlmacen",$idAlmacen,PDO::PARAM_STR);
            $stmt -> bindParam(":fechaDesde",$fechaDesde,PDO::PARAM_STR);
            $stmt -> bindParam(":fechaHasta",$fechaHasta,PDO::PARAM_STR);
           
        
            $stmt -> execute();
            return $stmt->fetchAll();
            
        } catch (Exception $e) {
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }
    
        $stmt = null;
    }

    static public function mdlAperturaCaja($monto_apertura, $idUsuario, $idAlmacen){

        $con = Conexion::conectar();
        $stmt = $con->prepare("INSERT INTO caja(fecha_apertura,monto_apertura,idUsuario,idAlmacen)
                                    VALUES (SYSDATE(),:monto_apertura,:idUsuario,:idAlmacen)");

            $stmt -> bindParam(":monto_apertura", $monto_apertura, PDO::PARAM_STR);
            $stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
            $stmt -> bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
          
            
            if($stmt -> execute()){
                $idd = $con->lastInsertId();
                return intval($idd);
                
            }else{
                return "Error, no se pudo aperturar caja";
            }        
        
        $stmt = null;

	}

    static public function mdlCierreCaja($idCaja,$monto_ingreso,$monto_egreso,$monto_cierre){

        $stmt = Conexion::conectar()->prepare("UPDATE caja SET estado = 1, 
                                                                fecha_cierre = SYSDATE(),
                                                                monto_ingreso = :monto_ingreso,
                                                                monto_egreso = :monto_egreso,
                                                                monto_cierre = :monto_cierre
                                                WHERE idCaja = :idCaja");

            $stmt -> bindParam(":idCaja", $idCaja, PDO::PARAM_STR);
            $stmt -> bindParam(":monto_ingreso", $monto_ingreso, PDO::PARAM_STR);
            $stmt -> bindParam(":monto_egreso", $monto_egreso, PDO::PARAM_STR);
            $stmt -> bindParam(":monto_cierre", $monto_cierre, PDO::PARAM_STR);
            
            if($stmt -> execute()){
                return "Se cerro caja correctamente.";
            }else{
                return "Error, no se pudo cerrar caja";
            }        
        
        $stmt = null;

	}

    static public function mdlTotalTodo($idCaja,$idUsuario,$fecha){

        try {

            $stmt = Conexion::conectar()->prepare("SELECT 

                                                    IFNULL(ROUND(sum(c.monto_apertura),2),0.00) as montoApertura, 

                                                    IFNULL((select ROUND(sum(vc.pago_efe),2)
                                                        from venta_cabecera vc 
                                                        WHERE vc.estado = 0
                                                        AND DATE(vc.fecha_venta) = DATE(:fecha) 
                                                        /*AND DATE_FORMAT(vc.fecha_venta, '%d-%m-%y') = DATE_FORMAT(SYSDATE(), '%d-%m-%y')*/
                                                        AND vc.idCaja = :idCaja ),0.00) as TotalVentas, 
                                                    
                                                    IFNULL((select ROUND(sum(mc.monto),2) 
                                                        from movimientos_caja mc 
                                                        WHERE mc.tipo = 'Ingreso'
                                                        AND DATE(mc.fecha) = DATE(:fecha) 
                                                        /*AND DATE_FORMAT(mc.fecha, '%d-%m-%y') = DATE_FORMAT(SYSDATE(), '%d-%m-%y')*/
                                                        AND mc.idCaja = :idCaja ),0.00) as Ingreso,
                                                    
                                                    IFNULL((select ROUND(sum(mc.monto),2) 
                                                        from movimientos_caja mc 
                                                        WHERE mc.tipo = 'Egreso' 
                                                        AND DATE(mc.fecha) = DATE(:fecha)
                                                        
                                                        AND mc.idCaja = :idCaja ),0.00) as Egreso
                                                       
                                                    
                                                    FROM caja c
                                                    WHERE c.idCaja = :idCaja
                                                    AND  DATE(c.fecha_apertura)= date(:fecha)");
                                                    /*AND DATE_FORMAT(c.fecha_apertura, '%d-%m-%y') = DATE_FORMAT(SYSDATE(), '%d-%m-%y')");*/
                                                   
            $stmt -> bindParam(":idCaja",$idCaja,PDO::PARAM_STR);
            $stmt -> bindParam(":idUsuario",$idUsuario,PDO::PARAM_STR);
            $stmt -> bindParam(":fecha",$fecha,PDO::PARAM_STR);
            
           
        
            $stmt -> execute();
            return $stmt->fetch();
            
        } catch (Exception $e) {
            return 'Excepción capturada: '.  $e->getMessage(). "\n";
        }
    
        $stmt = null;
    }

    static public function mdlGuardarDetalle($idCaja, $tipo, $descripcion,$monto,$idUsuario){

        $con = Conexion::conectar();
        $stmt = $con->prepare("INSERT INTO movimientos_caja(idCaja,tipo,descripcion,monto,idUsuario)
                                    VALUES (:idCaja,:tipo,:descripcion,:monto,:idUsuario)");

            $stmt -> bindParam(":idCaja", $idCaja, PDO::PARAM_STR);
            $stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
            $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt -> bindParam(":monto", $monto, PDO::PARAM_STR);
            $stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
          
            
            
            if($stmt -> execute()){
                return "El detalle fue guardado correctamente";
            }else{
                return "Error, no se pudo registrar el detalle";
            }          
        
        $stmt = null;

	}

    static public function mdlMostrarDetalleC($idCaja, $tipo,$fecha){

        $stmt = Conexion::conectar()->prepare("SELECT concat(SUBSTRING_INDEX (em.nombres,' ',1),' ',SUBSTRING_INDEX (em.apellidos,' ',1)) as empleado, mc.descripcion, CONCAT(emp.simbolom,' ',CONVERT(ROUND(mc.monto,2), CHAR)) as monto 
                                                FROM movimientos_caja mc
                                                LEFT JOIN usuario u ON mc.idUsuario = u.idUsuario
                                                LEFT JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                INNER JOIN empresa emp
                                                ON emp.idEmpresa = 1
                                                WHERE idCaja = :idCaja 
                                                AND tipo = :tipo  
                                                AND  DATE(fecha)= date(:fecha) ");

        $stmt -> bindParam(":idCaja",$idCaja,PDO::PARAM_STR);
        $stmt -> bindParam(":tipo",$tipo,PDO::PARAM_STR);
        $stmt -> bindParam(":fecha",$fecha,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
   
}

/* SELECT * FROM `caja` WHERE 
 AND DATE_FORMAT(fecha, '%d-%m-%y') = DATE_FORMAT(SYSDATE(), '%d-%m-%y') 
*/