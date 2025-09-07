<?php

require_once "conexion.php";

class ModelEmpleados{


	static public function mdlMostrarEmpleado($tabla, $item, $valor){

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY idEmpleado ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt = null;
	}

	static public function mdlMostrarEmpleados($tabla, $ordenar, $item, $valor, $base, $tope){

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT *FROM $tabla WHERE $item = :$item ORDER BY $ordenar ASC LIMIT $base, $tope");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT *FROM $tabla ORDER BY $ordenar ASC LIMIT $base, $tope");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		
		$stmt = null;

	}


	static public function mdlListarEmpleado($tabla, $ordenar ,$item, $valor){

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $ordenar DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}
		
		$stmt = null;
	}
	

	static public function mdlIngresarEmpleado($tabla ,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombres, apellidos,telefono,direccion,dni,correo,fecNacimiento,foto) VALUES (:nombres, :apellidos,:telefono,:direccion,:dni,:correo,:fecNacimiento, :foto)");
		$stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
        $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
        $stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecNacimiento", $datos["fecNacimiento"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		
		$stmt = null;
	}

	static public function mdlEditarEmpleado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono, direccion = :direccion, dni = :dni, correo = :correo, fecNacimiento = :fecNacimiento, foto = :foto WHERE idEmpleado = :idEmpleado");
		
		$stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecNacimiento", $datos["fecNacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":idEmpleado", $datos["idEmpleado"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		
		$stmt = null;

	}

	static public function mdlEliminarEmpleado($tabla, $id){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idEmpleado = :idEmpleado");
		$stmt -> bindParam(":idEmpleado", $id, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());
		}

		
		$stmt = null;

	}

	
	
	

	
	

}

