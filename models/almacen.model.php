<?php

require_once "conexion.php";

class ModelAlmacen{

/*=============================================
	CREAR ALMACEN
	=============================================*/

	static public function mdlIngresarAlmacen($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(descripcion, ubicacion, entrada, salida, estado) VALUES (:descripcion, :ubicacion,:entrada, :salida,:estado)");


		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":entrada", $datos["entrada"], PDO::PARAM_STR);
		$stmt->bindParam(":salida", $datos["salida"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;

	}

	/*=============================================
	MOSTRAR ALMACEN
	=============================================*/

	static public function mdlMostrarAlmacen($tabla, $item, $valor){

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
	EDITAR ALMACEN
	=============================================*/

	static public function mdlEditarAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcion = :descripcion, ubicacion = :ubicacion, entrada = :entrada, salida = :salida WHERE idAlmacen = :idAlmacen");

		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":entrada", $datos["entrada"], PDO::PARAM_STR);
		$stmt -> bindParam(":salida", $datos["salida"], PDO::PARAM_STR);
		$stmt -> bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt = null;

	}

	static public function mdlActualizarAlmacen($tabla, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt = null;
	}

	/*=============================================
	BORRAR ALMACEN
	=============================================*/

	static public function mdlBorrarAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idAlmacen = :idAlmacen");

		$stmt -> bindParam(":idAlmacen", $datos, PDO::PARAM_INT);

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