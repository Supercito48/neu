<?php

require_once "conexion.php";

class ModelKardex{

    
	static public function VerProductosKardex($tabla, $item, $valor, $item2, $valor2){

		if($item2 == null){
            
			$pdo = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$pdo -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$pdo -> execute();

			return $pdo -> fetchAll();

		}else{

			$pdo = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");

			$pdo -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$pdo -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			$pdo -> execute();

			return $pdo -> fetchAll();

		}

		
		$pdo = null;

	}

	static public function mdlVerKardex($idAlmacen, $fechaDesde, $fechaHasta){

		
            
		$stmt = Conexion::conectar()->prepare("SELECT k.fecha_registro, p.descProducto, k.motivo,k.tipo, k.habia,k.stock,k.hay, 
												concat(SUBSTRING_INDEX (em.nombres,' ',1),' ',SUBSTRING_INDEX (em.apellidos,' ',1)) as empleado 
												FROM kardex k 
												INNER JOIN producto p ON p.idProducto = k.idProducto 
												INNER JOIN usuario u ON u.idUsuario = k.idUsuario 
												INNER JOIN empleado em ON em.idEmpleado = u.idEmpleado 
												WHERE k.idAlmacen = :idAlmacen
												AND DATE(k.fecha_registro) >= date(:fechaDesde) and DATE(k.fecha_registro) <= date(:fechaHasta)");


		$stmt -> bindParam(":idAlmacen",$idAlmacen,PDO::PARAM_STR);
		$stmt -> bindParam(":fechaDesde",$fechaDesde,PDO::PARAM_STR);
		$stmt -> bindParam(":fechaHasta",$fechaHasta,PDO::PARAM_STR);
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt = null;

	}

    static public function mdlIngresarKardex($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
                                                    VALUES (:motivo,:stock,:idProducto, :idAlmacen, :idUsuario, :tipo, :estado, :habia, :hay)");


		$stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":habia", $datos["habia"], PDO::PARAM_STR);
        $stmt->bindParam(":hay", $datos["hay"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
		$stmt = null;

	}



}

