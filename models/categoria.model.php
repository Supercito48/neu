<?php

require_once "conexion.php";

class ModelCategorias{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarCategoria($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(desCat, estadoCat) VALUES (:desCat, :estadoCat)");


		$stmt->bindParam(":desCat", $datos["desCat"], PDO::PARAM_STR);
        $stmt->bindParam(":estadoCat", $datos["estadoCat"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

	
		$stmt = null;

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarCategorias($tabla, $item, $valor){

		if($item != null){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		//$stmt -> bindParam(":desCat".$item, $valor, PDO::PARAM_STR);
        $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
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
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET desCat = :desCat  WHERE idCategoria = :idCategoria");

		$stmt -> bindParam(":desCat", $datos["desCat"], PDO::PARAM_STR);
		$stmt -> bindParam(":idCategoria", $datos["idCategoria"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	static public function mdlActualizarCategoria($tabla, $item1, $valor1, $item2, $valor2)
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
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarCategoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idCategoria = :idCategoria");

		$stmt -> bindParam(":idCategoria", $datos, PDO::PARAM_INT);

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

