<?php

require_once "conexion.php";

class ModelClientes
{

	static public function mdlMostrarClientes($item, $valor)
	{
		if ($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM clientes WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch(); //fetch solko te trae un registro , //fetchall te traer todos los registros, 
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM clientes");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt = null;
	}

	static public function mdlMostrarCliente($idCliente)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM clientes WHERE idCliente = :idCliente");
		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch(); //fetch solko te trae un registro , //fetchall te traer todos los registros, 


	}
	static public function mdlRegistrarClientes($dni, $nombres, $direccion, $telefono, $limite_credito)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO clientes(dni,nombres,direccion,telefono,limite_credito,credito_usado) VALUES (:dni,:nombres,:direccion,:telefono,:limite_credito,:credito_usado)");

		$stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
		$stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
		$stmt->bindParam(":limite_credito", $limite_credito, PDO::PARAM_STR);
		$stmt->bindParam(":credito_usado", $limite_credito, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "El cliente se registró correctamente";
		} else {
			return "Error, no se pudo registrar el cliente";
		}
		$stmt = null;
	}

	static public function mdlEditarClientes($idCliente, $dni, $nombres, $direccion, $telefono, $limite_credito)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE clientes 
												SET dni = :dni,
												nombres =:nombres,
												direccion = :direccion,
												telefono = :telefono,
                                                limite_credito = :limite_credito
												WHERE idCliente = :idCliente ");

		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_INT);
		$stmt->bindParam(":dni", $dni, PDO::PARAM_INT);
		$stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $telefono, PDO::PARAM_STR);
		$stmt->bindParam(":limite_credito", $limite_credito, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "El cliente se edito correctamente";
		} else {
			return "Error, no se pudo editar el cliente";
		}
		$stmt = null;
	}

	static public function mdlBorrarClientes($idCliente)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM clientes WHERE idCliente  = :idCliente ");
		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_INT);
		try {
			$stmt->execute();
			return "ok";
		} catch (Exception $e) {
			return $e->getMessage();
		}
		$stmt = null;
	}

	//

	static public function mdlPagarCredito($idCliente, $monto, $comision, $metodo, $idCaja, $montoComparar)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE clientes SET 
												credito_usado = credito_usado - :comision,
                                                credito_usado = credito_usado + :monto
                                              
                                                WHERE idCliente = :idCliente");
		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_INT);
		$stmt->bindParam(":comision", $comision, PDO::PARAM_STR);
		$stmt->bindParam(":monto", $monto, PDO::PARAM_STR);



		if ($stmt->execute()) {

			$stmt = null;
			$stmt = Conexion::conectar()->prepare("INSERT pago_credito (idCliente,metodo,monto,idCaja)
                                                    VALUES ($idCliente,:metodo,$monto,:idCaja)");

			$stmt->bindParam(":metodo", $metodo, PDO::PARAM_STR);
			$stmt->bindParam(":idCaja", $idCaja, PDO::PARAM_STR);
			if ($stmt->execute()) {

				$stmt = null;
				$stmt = Conexion::conectar()->prepare("INSERT bitacora_credito (idCliente,descripcion,montod)
														VALUES ($idCliente,'ABONO -',CONCAT(' ', CAST($monto AS DECIMAL(7, 2))))");


				if ($stmt->execute()) {
					if ($montoComparar == 0) {
						$stmt = null;
						$stmt = Conexion::conectar()->prepare("UPDATE bitacora_credito SET 
												estado = 0
                                              
                                                WHERE idCliente = $idCliente");


						if ($stmt->execute()) {
							return "pago se efectuo correctamente";
						} else {
							return "Error, no se pudo pagar la cuota";
						}
					}
					return "pago se efectuo correctamente";
				} else {
					return "Error, no se pudo pagar la cuota";
				}
			} else {
				return "Error, no se pudo pagar la cuota";
			}
		} else {
			return "Error, no se pudo pagar la cuota";
		}
		$stmt = null;
	}

	static public function mdlMostrarFechaClient($idCliente)
	{

		$stmt = Conexion::conectar()->prepare("SELECT  date_format(fecha_venta , '%d-%m-%Y') fecha, GROUP_CONCAT(idVenta SEPARATOR ',') idVenta
												FROM venta_cabecera 
												WHERE idCliente = :idCliente
												GROUP BY  date_format(fecha_venta , '%d-%m-%Y')");
		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function mdlMostrarDetalleClient($idVenta)
	{

		$stmt = Conexion::conectar()->prepare("SELECT vd.idVenta,vd.codigo_producto,p.descProducto,
												CONCAT(' ',CONVERT(ROUND(vd.total_venta/vd.cantidad,2), CHAR)) as precio_venta,
												vd.cantidad,
												CONCAT(' ',CONVERT(ROUND(vd.total_venta,2), CHAR)) as total_venta
												FROM venta_detalle vd
												INNER JOIN producto p
												ON p.codigoBarras= vd.codigo_producto
												WHERE vd.idVenta in ($idVenta)");

		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function mdlMostrarDetalleAbono($idCliente)
	{

		$stmt = Conexion::conectar()->prepare("SELECT pc.idPagoc,pc.metodo, 
												CONCAT(c.simbolom,CONCAT(' ', CONVERT(ROUND(pc.monto,2), CHAR))) as monto,
												  
												date_format(fecha , '%d-%m-%Y') fecha
												FROM pago_credito pc
												INNER JOIN empresa c 
												ON c.idEmpresa = 1
												WHERE idCliente= :idCliente");
		$stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}