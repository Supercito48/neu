<?php

require_once "conexion.php";

class ModelProducto
{

	/*=============================================
	CREAR Producto
	=============================================*/

	static public function mdlIngresarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(descProducto, codigoBarras,idCategoria, precioCompra, precioVenta, precioVentaMA,  oferta) 
												VALUES (:descProducto, :codigoBarras,:idCategoria,:precioCompra, :precioVenta,:precioVentaMA, :oferta)");


		$stmt->bindParam(":descProducto", $datos["descProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":codigoBarras", $datos["codigoBarras"], PDO::PARAM_STR);
		$stmt->bindParam(":idCategoria", $datos["idCategoria"], PDO::PARAM_STR);
		$stmt->bindParam(":precioCompra", $datos["precioCompra"], PDO::PARAM_STR);
		$stmt->bindParam(":precioVenta", $datos["precioVenta"], PDO::PARAM_STR);
		$stmt->bindParam(":precioVentaMA", $datos["precioVentaMA"], PDO::PARAM_STR);
		$stmt->bindParam(":oferta", $datos["oferta"], PDO::PARAM_STR);


		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt = null;
	}

	/*=============================================
	MOSTRAR Producto
	=============================================*/


	static public function mdlMostrarProductoDeposito()
	{

		$stmt = Conexion::conectar()->prepare("SELECT P.* FROM producto P 
												LEFT JOIN deposito D
												ON P.idProducto = D.idProducto
												WHERE  D.idProducto IS NULL");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlMostrarProductoInventario($idAlmacen)
	{

		$stmt = Conexion::conectar()->prepare("SELECT P.* FROM producto P 
												LEFT JOIN inventario I
												ON P.idProducto = I.idProducto AND I.idAlmacen = :idAlmacen
												WHERE  I.idProducto IS NULL");
		$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlMostrarProducto($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		}


		$stmt = null;
	}
	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/
	//static public function mdlListarNombreProductos($idAlmacen){
	static public function mdlListarProductoCompra()
	{

		$stmt = Conexion::conectar()->prepare("SELECT Concat(codigoBarras  , ' - ',p.descProducto ,' - ', emp.simbolom,' ', p.precioCompra)  as descripcion_producto
												FROM producto p 
												inner join deposito c on p.idProducto = c.idProducto
												INNER JOIN empresa emp
												ON emp.idEmpresa = 1");
		//where idAlmacen = :idAlmacen
		//$stmt -> bindParam(":idAlmacen",$idAlmacen,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	//static public function mdlGetDatosProducto($codigoProducto, $idAlmacen){
	static public function mdlGetDatosProductoCompra($codigoProducto)
	{


		$stmt = Conexion::conectar()->prepare("SELECT  p.idProducto,
														p.codigoBarras,
														p.descProducto,
														'1' as cantidad,
														c.stock,
														CONCAT(emp.simbolom,' ',CONVERT(ROUND(p.precioCompra,2), CHAR)) as precio_compra_producto,
														CONCAT(emp.simbolom,' ',CONVERT(ROUND(1*p.precioCompra,2), CHAR)) as total
												FROM producto p inner join deposito c on p.idProducto = c.idProducto
												INNER JOIN empresa emp
												ON emp.idEmpresa = 1
												WHERE p.codigoBarras = :codigoProducto");
		//AND c.idAlmacen = :idAlmacen

		$stmt->bindParam(":codigoProducto", $codigoProducto, PDO::PARAM_INT);
		//$stmt -> bindParam(":idAlmacen",$idAlmacen,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	/*=============================================
	MOSTRAR VENTAS PRODUCTOS
	=============================================*/
	static public function mdlListarproductos($idAlmacen)
	{

		$stmt = Conexion::conectar()->prepare("SELECT  Concat(codigoBarras  , ' - ',p.descProducto ,' - ', emp.simbolom,' ', p.precioVenta) as descripcion_producto
												FROM producto p inner join inventario i on p.idProducto = i.idProducto
												INNER JOIN empresa emp
												ON emp.idEmpresa = 1
												where idAlmacen =:idAlmacen");

		$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function mdlGetDatosProductos($codigoProducto, $idAlmacen)
	{


		$stmt = Conexion::conectar()->prepare("SELECT 
												p.idProducto,
												p.codigoBarras,
												p.descProducto,
												i.idInventario,
												i.idAlmacen,
												i.stock,
												'1' as cantidad,
												CONCAT(emp.simbolom,' ',CONVERT(ROUND(p.precioVenta,2), CHAR)) as precio_venta_producto,
												CONCAT(emp.simbolom,' ',CONVERT(ROUND(1*p.precioVenta,2), CHAR)) as total,
												'' as acciones,
												p.precioVentaMA,
												p.oferta
												FROM producto p inner join inventario i on p.idProducto = i.idProducto
												INNER JOIN empresa emp
												ON emp.idEmpresa = 1
												WHERE p.codigoBarras = :codigoProducto
												AND i.idAlmacen = :idAlmacen
												AND i.stock > 0");


		$stmt->bindParam(":codigoProducto", $codigoProducto, PDO::PARAM_INT);
		$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	static public function mdlVerificaStockProducto($codigo_producto, $cantidad_a_comprar, $idAlmacen)
	{
		$stmt = Conexion::conectar()->prepare("SELECT   count(*),IFNULL(i.stock,0)
												FROM producto p inner join inventario i on p.idProducto = i.idProducto
												WHERE p.codigoBarras = :codigo_producto
												AND i.stock > :cantidad_a_comprar AND i.idAlmacen = :idAlmacen");

		$stmt->bindParam(":codigo_producto", $codigo_producto, PDO::PARAM_STR);
		$stmt->bindParam(":cantidad_a_comprar", $cantidad_a_comprar, PDO::PARAM_STR);
		$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();
	}
	/*=============================================
	EDITAR Producto
	=============================================*/

	static public function mdlEditarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descProducto = :descProducto, 
																 codigoBarras = :codigoBarras,
																 idCategoria =:idCategoria,
																 precioCompra = :precioCompra,
																 precioVenta = :precioVenta,
																 precioVentaMA = :precioVentaMA,
																 oferta = :oferta
																 WHERE idProducto = :idProducto");

		$stmt->bindParam(":descProducto", $datos["descProducto"], PDO::PARAM_STR);
		$stmt->bindParam(":codigoBarras", $datos["codigoBarras"], PDO::PARAM_STR);
		$stmt->bindParam(":idCategoria", $datos["idCategoria"], PDO::PARAM_STR);
		$stmt->bindParam(":precioCompra", $datos["precioCompra"], PDO::PARAM_STR);
		$stmt->bindParam(":precioVenta", $datos["precioVenta"], PDO::PARAM_STR);
		$stmt->bindParam(":precioVentaMA", $datos["precioVentaMA"], PDO::PARAM_STR);
		$stmt->bindParam(":oferta", $datos["oferta"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt = null;
	}


	static public function mdlEditarPrecio($idProducto, $precioCompra)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE producto SET precioCompra = :precioCompra
												WHERE idProducto = :idProducto");

		$stmt->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
		$stmt->bindParam(":precioCompra", $precioCompra, PDO::PARAM_STR);


		if ($stmt->execute()) {

			$resultado = "ok";
		} else {

			$resultado = "error";
		}

		return $resultado;
		$stmt = null;
	}



	/*=============================================
	BORRAR Producto
	=============================================*/

	static public function mdlBorrarProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idProducto = :idProducto");

		$stmt->bindParam(":idProducto", $datos, PDO::PARAM_INT);

		try {
			$stmt->execute();

			return "ok";
		} catch (Exception $e) {

			return $e->getMessage();
		}

		$stmt = null;
	}

	//

	static public function mdlMostrarBajosInv($idAlmacen)
	{
		if ($idAlmacen != null) {
			$stmt = Conexion::conectar()->prepare("SELECT count(*) as cantidadprom 
												FROM inventario 
												WHERE stock <= stock_minimo 
												AND idAlmacen = :idAlmacen");
			$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT count(*) as cantidadprom 
												FROM inventario 
												WHERE stock <= stock_minimo");
			$stmt->execute();
			return $stmt->fetch();
		}
		$stmt = null;
	}

	static public function mdlMostrarBajosInvD($idAlmacen)
	{
		if ($idAlmacen != null) {
			$stmt = Conexion::conectar()->prepare("SELECT i.idProducto, p.codigoBarras,p.descProducto,  CONCAT(emp.simbolom,' ',CONVERT(ROUND(p.precioVenta,2), CHAR)) as precioVenta, i.stock, i.stock_minimo, a.descripcion
													FROM inventario i
													INNER JOIN producto p
													ON i.idProducto = p.idProducto
													INNER JOIN almacen a
													ON a.idAlmacen = i.idAlmacen
													INNER JOIN empresa emp
                          							ON emp.idEmpresa = 1
													WHERE i.stock <= i.stock_minimo
													AND i.idAlmacen = :idAlmacen");
			$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT i.idProducto, p.codigoBarras,p.descProducto,  CONCAT(emp.simbolom,' ',CONVERT(ROUND(p.precioVenta,2), CHAR)) as precioVenta, i.stock, i.stock_minimo, a.descripcion
													FROM inventario i
													INNER JOIN producto p
													ON i.idProducto = p.idProducto
													INNER JOIN almacen a
													ON a.idAlmacen = i.idAlmacen
													INNER JOIN empresa emp
                          							ON emp.idEmpresa = 1
													WHERE i.stock <= i.stock_minimo");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt = null;
	}

	static public function mdlMostrarMasVendido($idAlmacen)
	{
		if ($idAlmacen != null) {
			$stmt = Conexion::conectar()->prepare("SELECT v.codigo_producto, p.descProducto,sum(round(v.cantidad)) cantidad,  CONCAT(emp.simbolom,' ',CONVERT(SUM(ROUND(v.total_venta,2)), CHAR)) as total
													FROM venta_detalle v 
													inner join producto p  ON p.codigoBarras = v.codigo_producto 
													inner join venta_cabecera vc  ON vc.idVenta  = v.idVenta 
													INNER JOIN empresa emp
													ON emp.idEmpresa = 1
													WHERE vc.idAlmacen = :idAlmacen
													group by v.codigo_producto, p.descProducto
													order by sum(v.total_venta) desc
													limit 10");
			$stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchAll();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT v.codigo_producto, p.descProducto,sum(round(v.cantidad)) cantidad,  CONCAT(emp.simbolom,' ',CONVERT(SUM(ROUND(v.total_venta,2)), CHAR)) as total
													FROM venta_detalle v 
													inner join producto p  ON p.codigoBarras = v.codigo_producto 
													inner join venta_cabecera vc  ON vc.idVenta  = v.idVenta 
													INNER JOIN empresa emp
													ON emp.idEmpresa = 1
													group by v.codigo_producto, p.descProducto
													order by sum(v.total_venta) desc
													limit 10");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		$stmt = null;
	}
}

//