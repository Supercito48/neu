<?php

require_once "conexion.php";

class ModelConfiguracion
{

	static public function mdlMostrarConfiguracion()
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM empresa");
		
		$stmt->execute();
		return $stmt->fetchAll(); 
	}

    static public function mdlEditarEmpresa($idEmpresa, $logo, $ruc, $razon_social, $direccion, $email,$moneda,$simbolom,$impuesto)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE empresa 
												SET logo = :logo,
												ruc =:ruc,
												razon_social = :razon_social,
												direccion = :direccion,
                                                email = :email,
                                                moneda = :moneda,
												simbolom = :simbolom,
                                                impuesto = :impuesto
												WHERE idEmpresa = :idEmpresa ");

		$stmt->bindParam(":idEmpresa", $idEmpresa, PDO::PARAM_INT);
		$stmt->bindParam(":logo", $logo, PDO::PARAM_STR);
		$stmt->bindParam(":ruc", $ruc, PDO::PARAM_STR);
		$stmt->bindParam(":razon_social", $razon_social, PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":moneda", $moneda, PDO::PARAM_STR);
		$stmt->bindParam(":simbolom", $simbolom, PDO::PARAM_STR);
		
        $stmt->bindParam(":impuesto", $impuesto, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "La empresa se edito correctamente";
		} else {
			return "Error, no se pudo editar la empresa";
		}
		$stmt = null;
	}



	
}