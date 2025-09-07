<?php

require_once "../controllers/perfil.controller.php";
require_once "../models/perfil.model.php";

class AjaxPerfil
{
	public $idPerfil;
    public $descPerfil;
    
	public function ajaxMostrarPerfil(){
		$respuesta = ControllerPerfil::ctrMostrarPerfil("idPerfil", $_POST["idPerfil"]);
		echo json_encode($respuesta);
	}
    
	public function ajaxRegistrarPerfiles(){	
		$respuesta = ControllerPerfil::ctrRegistrarPerfiles($this->descripcion);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function ajaxEditarPerfiles(){	
		$respuesta = ControllerPerfil::ctrEditarPerfiles($this->idPerfiles,$this->descripcion);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function ajaxEliminarPerfiles(){	
		$respuesta = ControllerPerfil::ctrEliminarPerfiles($this->idPerfiles,$this->estado);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

/*  static public function ctrRegistrarPermisos($idPerfiles, $idMenu){
        $permisos = ModelPerfil::mdlRegistrarPermisos($idPerfiles, $idMenu);
        return $permisos;
    }

    static public function ctrDesactivarPermiso($idPermiso){
        $permisos = ModelPerfil::mdlDesactivarPermiso($idPermiso);
        return $permisos;
    }

    static public function ctrActivarPermiso($idPermiso){
        $permisos = ModelPerfil::mdlActivarPermiso($idPermiso);
        return $permisos;
    }*/

	public function ajaxRegistrarPermisos(){	
		$respuesta = ControllerPerfil::ctrRegistrarPermisos($this->idPerfiles,$this->idMenu);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function ajaxDesactivarPermiso(){	
		$respuesta = ControllerPerfil::ctrDesactivarPermiso($this->idPermiso);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}

	public function ajaxActivarPermiso(){	
		$respuesta = ControllerPerfil::ctrActivarPermiso($this->idPermiso);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
}


if(isset($_POST["ajaxPerfil"])){
	$leerPerfil = new AjaxPerfil();
	$leerPerfil -> ajaxMostrarPerfil();
}

if (isset($_POST["ajaxAgregarPerfiles"])) {
    $perfiles = new ajaxPerfil();
    $perfiles->descripcion = $_POST["descripcion"];
    $perfiles -> ajaxRegistrarPerfiles();
}

if (isset($_POST["ajaxEditarPerfiles"])) {
    $perfiles = new ajaxPerfil();
	$perfiles->idPerfiles = $_POST["idPerfiles"];
    $perfiles->descripcion = $_POST["descripcion"];
    $perfiles -> ajaxEditarPerfiles();
}

if (isset($_POST["ajaxEliminarPerfiles"])) {
    $perfiles = new ajaxPerfil();
	$perfiles->idPerfiles = $_POST["idPerfiles"];
	$perfiles->estado = $_POST["estado"];
    $perfiles -> ajaxEliminarPerfiles();
}


if (isset($_POST["ajaxRegistrarPermisos"])) {
    $permisos = new ajaxPerfil();
	$permisos->idPerfiles = $_POST["idPerfiles"];
    $permisos->idMenu = $_POST["idMenu"];
    $permisos -> ajaxRegistrarPermisos();
}

if (isset($_POST["ajaxDesactivarPermiso"])) {
    $permisos = new ajaxPerfil();
	$permisos->idPermiso = $_POST["idPermiso"];
    $permisos -> ajaxDesactivarPermiso();
}

if (isset($_POST["ajaxActivarPermiso"])) {
    $permisos = new ajaxPerfil();
	$permisos->idPermiso = $_POST["idPermiso"];
    $permisos -> ajaxActivarPermiso();
}