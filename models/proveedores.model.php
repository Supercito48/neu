<?php

require_once "conexion.php";

class ModelProveedores{

	/*=============================================
	CREAR PROVEEDORES
	=============================================*/

	static public function mdlIngresarProveedores($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(RUC, nombre,direccion,celular,telefono,email) VALUES (:RUC, :nombre,:direccion,:celular,:telefono,:email)");

		$stmt->bindParam(":RUC", $datos["RUC"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarProvedores($tabla, $item, $valor){
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
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarProveedores($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET RUC = :RUC,nombre = :nombre,direccion = :direccion,celular = :celular,telefono = :telefono,email = :email  WHERE idProveedor = :idProveedor");

        $stmt->bindParam(":RUC", $datos["RUC"], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);

		$stmt -> bindParam(":idProveedor", $datos["idProveedor"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}



	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function mdlBorrarProveedores($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idProveedor = :idProveedor");
		$stmt -> bindParam(":idProveedor", $datos, PDO::PARAM_INT);
		try
            {
                $stmt -> execute();
                return "ok";
		    }catch(Exception $e ){

			    return $e->getMessage();	
            }

		$stmt -> close();

		$stmt = null;

	}

}

