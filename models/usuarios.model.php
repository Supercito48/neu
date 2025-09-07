<?php 

require_once "conexion.php";

class ModelUsuarios
{
    static public function mdlMostrarUsuarios($tabla, $item, $valor)
	{
		if($item !=null){
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

	static public function mdlIngresarUsuarios($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idEmpleado, idAlmacen,login, passlogin, idPerfil, estado) VALUES (:idEmpleado, :idAlmacen,:login,:passlogin, :idPerfil,:estado)");


		$stmt->bindParam(":idEmpleado", $datos["idEmpleado"], PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":login", $datos["login"], PDO::PARAM_STR);
		$stmt->bindParam(":passlogin", $datos["passlogin"], PDO::PARAM_STR);
        $stmt->bindParam(":idPerfil", $datos["idPerfil"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);


		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlEditarUsuarios($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idEmpleado = :idEmpleado, idAlmacen = :idAlmacen, login = :login, passlogin = :passlogin, idPerfil =:idPerfil  WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idEmpleado", $datos["idEmpleado"], PDO::PARAM_STR);
		$stmt->bindParam(":idAlmacen", $datos["idAlmacen"], PDO::PARAM_STR);
		$stmt->bindParam(":login", $datos["login"], PDO::PARAM_STR);
		$stmt->bindParam(":passlogin", $datos["passlogin"], PDO::PARAM_STR);
		$stmt->bindParam(":idPerfil", $datos["idPerfil"], PDO::PARAM_STR);
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
	static public function mdlActualizarUsuarios($tabla, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	static public function mdlBorrarUsuarios($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idUsuario", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
}