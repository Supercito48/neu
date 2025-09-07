<?php

require_once "conexion.php";

class ModelComprobante{

	
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function mdlMostrarComprobantes($item, $idAlmacen){
        if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM docalmacen WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $idAlmacen, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll(); //fetch solko te trae un registro , //fetchall te traer todos los registros, 
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM docalmacen");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt = null;
	}

	static public function mdlMostrarComprobante($idDocalmacen){
        
		$stmt = Conexion::conectar()->prepare("SELECT * FROM docalmacen WHERE idDocalmacen = :idDocalmacen");
		$stmt -> bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch(); //fetch solko te trae un registro , //fetchall te traer todos los registros, 
		
		
	}
    static public function mdlRegistrarComprobante($idAlmacen, $Documento, $Serie, $Cantidad){

		$stmt = Conexion::conectar()->prepare("INSERT INTO docalmacen(idAlmacen,Documento,Serie,Cantidad) VALUES (:idAlmacen,:Documento,:Serie,:Cantidad)");

		$stmt -> bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
		$stmt -> bindParam(":Documento", $Documento, PDO::PARAM_STR);
		$stmt -> bindParam(":Serie", $Serie, PDO::PARAM_STR);
		$stmt -> bindParam(":Cantidad", $Cantidad, PDO::PARAM_STR);

		if($stmt -> execute()){
            return "La categoría se registró correctamente";
        }else{
            return "Error, no se pudo registrar el comprobante";
        }        
        $stmt = null;
	}

	static public function mdlEditarComprobante($idDocalmacen,$idAlmacen, $Documento, $Serie, $Cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE docalmacen 
												SET idAlmacen = :idAlmacen,
												Documento =:Documento,
												Serie = :Serie,
												Cantidad = :Cantidad
												WHERE idDocalmacen = :idDocalmacen ");

		$stmt -> bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_INT);
		$stmt -> bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
		$stmt -> bindParam(":Documento", $Documento, PDO::PARAM_STR);
		$stmt -> bindParam(":Serie", $Serie, PDO::PARAM_STR);
		$stmt -> bindParam(":Cantidad", $Cantidad, PDO::PARAM_STR);

		if($stmt -> execute()){
            return "El documento se edito correctamente";
        }else{
            return "Error, no se pudo editar el comprobante";
        }        
        $stmt = null;
	}

	static public function mdlBorrarComprobante($idDocalmacen){

		$stmt = Conexion::conectar()->prepare("DELETE FROM docalmacen WHERE idDocalmacen  = :idDocalmacen ");
		$stmt -> bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_INT);
        try {
            $stmt -> execute();
            return "ok";
        }
            catch(Exception $e ){
            return $e->getMessage();	
        }   
		$stmt = null;
	}
}

