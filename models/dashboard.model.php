<?php

require_once "conexion.php";
date_default_timezone_set("America/Lima");


class DashboardModel{

    
    static public function mdlTotalProductos(){
        $stmt = Conexion::conectar()->prepare("SELECT count(*) AS 'TotalProductos' FROM producto");
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlTotalConejos(){
        $stmt = Conexion::conectar()->prepare("SELECT count(*) AS 'TotalConejos' FROM empleado");
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlTotalEmpleado(){
        $stmt = Conexion::conectar()->prepare("SELECT count(*) AS 'TotalEmpleado' FROM empleado");
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlTotalAlmacen(){
        $stmt = Conexion::conectar()->prepare("SELECT count(*) AS 'TotalAlmacen' FROM almacen");
        $stmt -> execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlTotalVCP($idAlmacen){
        if($idAlmacen != null){
			$stmt = Conexion::conectar()->prepare("SELECT 
                                                    IFNULL((SELECT 
                                                            CONCAT('S./ ', sum(round(v.total_venta,2)))
                                                            FROM venta_cabecera v  
                                                            WHERE date(v.fecha_venta) >= date(LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY) 
                                                            and date(v.fecha_venta) <= LAST_DAY(date(CURRENT_DATE)) 
                                                            and v.idAlmacen = :idAlmacen),0.00) as TotalVentaMes, 
                                                    
                                                    IFNULL((SELECT 
                                                            CONCAT('S./ ',CONVERT(ROUND(sum(v.total_venta),2),CHAR))
                                                            from venta_cabecera v 
                                                            where date(v.fecha_venta) = Curdate()
                                                            and v.idAlmacen = :idAlmacen ),0.00) as TotalVentaDia
                                                            
                                                  ");

			$stmt -> bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT 
                                                    IFNULL((SELECT 
                                                            CONCAT('S./ ', sum(round(v.total_venta,2)))
                                                            FROM venta_cabecera v  
                                                            WHERE date(v.fecha_venta) >= date(LAST_DAY(NOW() - INTERVAL 1 MONTH) + INTERVAL 1 DAY) 
                                                            and date(v.fecha_venta) <= LAST_DAY(date(CURRENT_DATE)) ),0.00) as TotalVentaMes, 
                                                    
                                                    IFNULL((SELECT 
                                                            CONCAT('S./ ',CONVERT(ROUND(sum(v.total_venta),2),CHAR))
                                                            from venta_cabecera v 
                                                            where date(v.fecha_venta) = Curdate() ),0.00) as TotalVentaDia
                                                            
                                                   ");
			$stmt -> execute();
			return $stmt -> fetch();
		}
		$stmt = null;
	}

   
}