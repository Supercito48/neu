<?php

require_once "conexion.php";
class ModelDeposito
{

	static public function mdlVerDepositoPrueba()
	{
		$stmt = Conexion::conectar()->prepare("SELECT  *
											   FROM deposito");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlVerDeposito()
	{
		$stmt = Conexion::conectar()->prepare("SELECT  d.idDeposito,p.idProducto,p.codigoBarras,p.descProducto,d.stock  
											   FROM deposito d
											   INNER JOIN producto p ON p.idProducto = d.idProducto");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlVerDepositoProducto($idProducto)
	{
		$stmt = Conexion::conectar()->prepare("SELECT d.idDeposito, p.codigoBarras,p.descProducto,d.stock FROM deposito d 
                                                INNER JOIN producto p ON d.idProducto = p.idProducto
                                                WHERE  d.idProducto = :idProducto");

		$stmt->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mldMostrarDeposito($idDeposito)
	{
		$stmt = Conexion::conectar()->prepare("SELECT d.idDeposito,p.idProducto, p.codigoBarras, p.descProducto, d.stock from deposito d INNER JOIN
													producto p ON d.idProducto = p.idProducto
													where d.idDeposito = :idDeposito");
		$stmt->bindParam(":idDeposito", $idDeposito, PDO::PARAM_STR);

		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlRegistroDeposito($idProducto, $stock,$idUsuario)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO deposito(idProducto, stock) VALUES (:idProducto, :stock)");
		$stmt->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
		$stmt->bindParam(":stock", $stock, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Registro Inicial',$stock, $idProducto, '0', :idUsuario , 'Entrada', 1, '0', $stock)");
		
			$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
			

			if ($stmt->execute()) {
				return true;
			}
		}
		$stmt = null;
	}

	/*static public function mdlRegistroDeposito($tablaBD, $datosC)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tablaBD (stock, idProducto) VALUES (:stock, :idProducto)");
		$stmt->bindParam(":stock", $datosC["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":idProducto", $datosC["idProducto"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Registro Inicial',:stock, :idProducto, '0',:idUsuario, 'Entrada', 1, '0', :hay)");
			$stmt->bindParam(":idProducto", $datosC["idProducto"], PDO::PARAM_STR);
			$stmt->bindParam(":stock", $datosC["stock"], PDO::PARAM_STR);
			$stmt->bindParam(":idUsuario", $_SESSION["idUsuario"], PDO::PARAM_STR);
			$stmt->bindParam(":hay", $datosC["stock"], PDO::PARAM_STR);

			if ($stmt->execute()) {
				return true;
			}
		}
		$stmt = null;
	}*/

	static public function mdlEditarStock($idDeposito, $stock, $idProducto, $idUsuario, $habia)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE deposito SET stock = stock + :stock WHERE idDeposito = :idDeposito");
		$stmt->bindParam(":idDeposito", $idDeposito, PDO::PARAM_STR);
		$stmt->bindParam(":stock", $stock, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Aumento de stock',$stock ,$idProducto,'0',$idUsuario ,'Entrada',1, $habia, $stock + $habia)");
			if ($stmt->execute()) {
				$resultado = "Se aumento stock correctamente.";
			} else {
				$resultado = "Error al editar stock";
			}
		}
		return $resultado;
		$stmt = null;
	}

	static public function mdlEditarAjuste($idDeposito, $stock, $idProducto, $idUsuario, $habia)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE deposito SET stock = :stock WHERE idDeposito = :idDeposito");
		$stmt->bindParam(":idDeposito", $idDeposito, PDO::PARAM_STR);
		$stmt->bindParam(":stock", $stock, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Ajuste de stock',$stock ,$idProducto,'0',$idUsuario ,'Ajuste',1, $habia, $stock )");
			if ($stmt->execute()) {
				$resultado = "Se aumento stock correctamente.";
			} else {
				$resultado = "Error al editar stock";
			}
		}
		return $resultado;
		$stmt = null;
	}

	static public function mdlEditarTraslado($idDeposito, $stock, $idAlmacen, $idProducto, $idUsuario, $habia, $habidst)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE deposito SET stock = stock - :stock WHERE idDeposito = :idDeposito");
		$stmt->bindParam(":idDeposito", $idDeposito, PDO::PARAM_STR);
		$stmt->bindParam(":stock", $stock, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ((SELECT Concat('Traslado enviad a ',descripcion) descripcion FROM almacen WHERE idAlmacen = $idAlmacen),$stock ,$idProducto,'0',$idUsuario ,'Salida',1, $habia,  $habia -$stock  )");
			if ($stmt->execute()) {
				$stmt = null;
				$stmt = Conexion::conectar()->prepare("UPDATE inventario SET stock = stock + $stock
														 WHERE idAlmacen = $idAlmacen AND idProducto = $idProducto");

				if ($stmt->execute()) {
					$stmt = null;
					$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
															VALUES ('Traslado enviado de Deposito' ,$stock ,$idProducto,$idAlmacen,$idUsuario ,'Entrada',1, $habidst, $stock + $habidst )");

					if ($stmt->execute()) {
						$resultado = "Se traslado stock correctamente.";
					} else {
						$resultado = "Error al editar stock";
					}
				}
			} else {
				$resultado = "Error al registrar la venta";
			}
		}
		return $resultado;
		$stmt = null;
	}

	static public function mdlBorrarDeposito($idDeposito,$stock,$idProducto,$idUsuario)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM deposito WHERE idDeposito = :idDeposito");

		$stmt->bindParam(":idDeposito", $idDeposito, PDO::PARAM_INT);

		if ($stmt->execute()) {

			$stmt = null;

			$stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Elimianado de inventario',$stock ,$idProducto,'0',$idUsuario ,'Eliminado',1, $stock, '0')");
			if ($stmt->execute()) {
				$resultado = "Se elimino correctamente.";
			} else {
				$resultado = "Error al eliminar stock";
			}
		}


		return $resultado;
		$stmt = null;
	}
}
