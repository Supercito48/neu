<?php

require_once "conexion.php";

class ModelInventario{

    
	static public function VerProductosInventarioM($tabla, $item, $valor, $item2, $valor2){

		if($item2 == null){
            
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		
		$stmt = null;

	}

	static public function mdlVerInventario($idAlmacen)
	{
		$stmt = Conexion::conectar()->prepare("SELECT i.idInventario,i.idAlmacen, i.idProducto, p.codigoBarras, p.descProducto,c.desCat, i.stock, i.stock_minimo FROM inventario i 
												INNER JOIN producto p 
												ON p.idProducto = i.idProducto
												INNER JOIN categoria c
												ON c.idCategoria = p.idCategoria
												WHERE i.idAlmacen = :idAlmacen");

		$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlTotalInventario($idAlmacen)
    {

        $stmt = Conexion::conectar()->prepare("SELECT IFNULL(ROUND(SUM(i.stock * p.precioCompra),2),'0.00') total_inventario,
												IFNULL(ROUND(SUM(i.stock),2),'0.00') total_cantidad
												FROM inventario i 
												INNER JOIN producto p 
												ON p.idProducto = i.idProducto
												INNER JOIN categoria c
												ON c.idCategoria = p.idCategoria
												WHERE i.idAlmacen = :idAlmacen");

        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }

	static public function mdlTraslado($tabla, $item11, $valor11, $item22 ,$valor22){

		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item11 = :$item11 AND $item22 = :$item22");

		$stmt -> bindParam(":".$item11, $valor11, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item22, $valor22, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
	

		

		$stmt = null;

	}
	static public function mdlIngresarInventario($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idAlmacen,idProducto, stock, stock_minimo,idUsuario) VALUES (:idAlmacen,:idProducto,:stock, :stock_minimo,:idUsuario)");

	
		$stmt->bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
        $stmt->bindParam(":stock_minimo", $datos["stock_minimo"], PDO::PARAM_STR);
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	/*=============================================
	MOSTRAR Inventario
	=============================================*/

	static public function mdlMostrarInventario($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		

		$stmt = null;

	}

	/*=============================================
	EDITAR Inventario
	=============================================*/

	static public function mdlEditarStock($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = :stock WHERE idInventario = :idInventario");
		
		$stmt -> bindParam(":idInventario", $datos["idInventario"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
        
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	/*=============================================
	TRANSFERENCIA DE INVENTARIO
	=============================================*/

	static public function mdlTrasladoStock($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = :stock  WHERE idAlmacen = :idAlmacen AND idProducto = :idProducto");
		
		$stmt -> bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
        
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}


	/*=============================================
	BORRAR Inventario
	=============================================*/

	static public function mdlBorrarInventario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idInventario = :idInventario");

		$stmt -> bindParam(":idInventario", $datos, PDO::PARAM_INT);

		try 
                {
                    $stmt -> execute();

                    return "ok";
		
		}
                
                catch(Exception $e ){

			return $e->getMessage();	

		}

		

		$stmt = null;

	}

}