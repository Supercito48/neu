<?php

require_once "conexion.php";

class ModelPerfil{

	/*=============================================
	PERFILES
	=============================================*/

	static public function mdlMostrarPerfiles($tabla, $item, $valor){
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

	static public function mdlRegistrarPerfiles($descripcion){
        $con = Conexion::conectar();
        $stmt = $con->prepare("INSERT INTO perfiles(descripcion,estado)
                                    VALUES (:descripcion,0)");
        $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        If($stmt -> execute()){
            return "agregado correctamente";
        }else{
            return "Error, no se pudo registrar la cita";
        }       
        $stmt = null;

	}

	static public function mdlEditarPerfiles($idPerfiles,$descripcion){
        $con = Conexion::conectar();
        $stmt = $con->prepare("UPDATE perfiles SET 
									descripcion = :descripcion
									WHERE idPerfiles  = :idPerfiles ");
		$stmt -> bindParam(":idPerfiles", $idPerfiles , PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
        if($stmt -> execute()){  
        	return "editado correctamente";
		}else{
        	return "Error, no se pudo registrar la cita";
        }       
        $stmt = null;
	}

	static public function mdlEliminarPerfiles($idPerfiles,$estado){

        $con = Conexion::conectar();
        $stmt = $con->prepare("UPDATE perfiles SET 
									estado = :estado
									WHERE idPerfiles  = :idPerfiles ");
		$stmt -> bindParam(":idPerfiles", $idPerfiles , PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $estado , PDO::PARAM_STR);
        if($stmt -> execute()){
            return "eliminado correctamente";
        }else{
            return "Error, no se pudo registrar la cita";
        }       
        $stmt = null;

	}

	/*static public function mdlIngresarPerfil($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO perfil (descPerfil,
																	veralmacen, 
																	agralmacen, 
																	editalmacen, 
																	elimalmacen, 
																	verempleado, 
																	agrempleado,
																	editempleado,
																	elimempleado,
																	verusuarios,
																	agrusuarios,
																	editusuarios,
																	elimusuarios,
																	verprov,
																	agrprov,
																	editprov,
																	elimprov,
																	verservicio,
																	agrservicio,
																	editservicio,
																	elimservicio,
																	verperfil,
																	agrperfil,
																	editperfil,
																	elimperfil,
																	vercat,
																	agrcat,
																	editcat,
																	elimcat,
																	verproduc,
																	agrproduc,
																	editproduc,
																	elimproduc,
																	verinv,
																	agrinv,
																	suminv,
																	ajusinv,
																	trasinv,
																	eliminv,
																	verkardex,
																	verdep,
																	agrdep,
																	sumdep,
																	ajusdep,
																	trasdep,
																	elimdep,
																	nuevacompra,
																	vercompra,
																	anulcompra,
																	nuevaventa,
																	verventa,
																	anulventa,
																	vercomprob,
																	agrcomprob,
																	editcomprob,
																	elimcomprob,
																	vercaja,
																	apercaja,
																	ingcaja,
																	egrcaja,
																	detcaja,
																	cerracaja,
																	vercita,
																	agrcita,
																	impcita,
																	editcita,
																	elimcita,
																	servcita,
																	pagcita,
																	impbolcita,
																	verhm,
																	atenderhm,
																	vercm,
																	atendercm,
																	verorden,
																	agrorden,
																	editorden,
																	elimorden,
																	resulorden,
																	pagorden,
																	imporden,
																	impborden,
																	verconejo,
																	verraza,
																	verrecep,
																	verproceso,
																	impproceso,
																	elimproceso,
																	verhab,
																	agrhab,
																	edithab,
																	elimhab, 
																	manthab) 
															VALUES (:descPerfil,
																	:veralmacen, 
																	:agralmacen, 
																	:editalmacen, 
																	:elimalmacen, 
																	:verempleado, 
																	:agrempleado,
																	:editempleado,
																	:elimempleado,
																	:verusuarios,
																	:agrusuarios,
																	:editusuarios,
																	:elimusuarios,
																	:verprov,
																	:agrprov,
																	:editprov,
																	:elimprov,
																	:verservicio,
																	:agrservicio,
																	:editservicio,
																	:elimservicio,
																	:verperfil,
																	:agrperfil,
																	:editperfil,
																	:elimperfil,
																	:vercat,
																	:agrcat,
																	:editcat,
																	:elimcat,
																	:verproduc,
																	:agrproduc,
																	:editproduc,
																	:elimproduc,
																	:verinv,
																	:agrinv,
																	:suminv,
																	:ajusinv,
																	:trasinv,
																	:eliminv,
																	:verkardex,
																	:verdep,
																	:agrdep,
																	:sumdep,
																	:ajusdep,
																	:trasdep,
																	:elimdep,
																	:nuevacompra,
																	:vercompra,
																	:anulcompra,
																	:nuevaventa,
																	:verventa,
																	:anulventa,
																	:vercomprob,
																	:agrcomprob,
																	:editcomprob,
																	:elimcomprob,
																	:vercaja,
																	:apercaja,
																	:ingcaja,
																	:egrcaja,
																	:detcaja,
																	:cerracaja,
																	:vercita,
																	:agrcita,
																	:impcita,
																	:editcita,
																	:elimcita,
																	:servcita,
																	:pagcita,
																	:impbolcita,
																	:verhm,
																	:atenderhm,
																	:vercm,
																	:atendercm,
																	:verorden,
																	:agrorden,
																	:editorden,
																	:elimorden,
																	:resulorden,
																	:pagorden,
																	:imporden,
																	:impborden,
																	:verconejo,
																	:verraza,
																	:verrecep,
																	:verproceso,
																	:impproceso,
																	:elimproceso,
																	:verhab,
																	:agrhab,
																	:edithab,
																	:elimhab, 
																	:manthab) ");
		$stmt->bindParam(":descPerfil", $datos, PDO::PARAM_STR);
   

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}*/

	/*=============================================
	MOSTRAR MENUS
	=============================================*/

	static public function mdlMostrarMenus(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM menus");
		$stmt -> execute();
		return $stmt -> fetchAll();

	}

	/*=============================================
	VERIFICAR SI EXISTE EL MENU CON EL PERFIL Y PERMISOS - PARA HACERE LA SESION 
	=============================================*/
	static public function mdlMostrarMenuPermisos($idMenu, $idPerfiles)
    {
        $stmt = Conexion::conectar()->prepare("SELECT pm.idPermiso,pm.idMenu, p.descripcion, m.acronimo,pm.estado,COUNT(*) as existe FROM permiso pm
												INNER JOIN perfiles p ON pm.idPerfiles = p.idPerfiles
												INNER JOIN menus m ON pm.idMenu = m.idMenu
												WHERE pm.idMenu = :idMenu
												AND pm.idPerfiles = :idPerfiles");
        $stmt->bindParam(":idMenu", $idMenu, PDO::PARAM_STR);
		$stmt->bindParam(":idPerfiles", $idPerfiles, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch();
    }

	/*=============================================
	AGREGAR PERMISOS
	=============================================*/
	

	static public function mdlRegistrarPermisos($idPerfiles, $idMenu){
        $con = Conexion::conectar();
        $stmt = $con->prepare("INSERT INTO permiso(idPerfiles,idMenu,estado)
                                    VALUES (:idPerfiles,:idMenu,'on')");
        $stmt -> bindParam(":idPerfiles", $idPerfiles, PDO::PARAM_STR);
		$stmt -> bindParam(":idMenu", $idMenu, PDO::PARAM_STR);
        If($stmt -> execute()){
            return "agregado correctamente";
        }else{
            return "Error, no se pudo registrar la cita";
        }       
        $stmt = null;

	}

	static public function mdlDesactivarPermiso($idPermiso){
        $con = Conexion::conectar();
        $stmt = $con->prepare("UPDATE permiso SET 
									estado = 'off'
									WHERE idPermiso  = :idPermiso");
		$stmt -> bindParam(":idPermiso",$idPermiso,PDO::PARAM_STR);
        if($stmt -> execute()){  
        	return "desactivado correctamente";
		}else{
        	return "Error, no se pudo desactivar el permiso";
        }       
        $stmt = null;
	}

	static public function mdlActivarPermiso($idPermiso){
        $con = Conexion::conectar();
        $stmt = $con->prepare("UPDATE permiso SET 
									estado = 'on'
									WHERE idPermiso  = :idPermiso");
		$stmt -> bindParam(":idPermiso",$idPermiso,PDO::PARAM_STR);
        if($stmt -> execute()){  
        	return "activado correctamente";
		}else{
        	return "Error, no se pudo activar el permiso";
        }       
        $stmt = null;
	}
	
}

