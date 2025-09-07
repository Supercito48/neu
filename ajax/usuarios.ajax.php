<?php

require_once "../controllers/usuarios.controller.php";
require_once "../models/usuarios.model.php";

class AjaxUsuario
{

    // /*=============================================
	// Editar tipopago traer datos al modal
	// =============================================*/	

	public function ajaxMostrarUsuarios(){

		$respuesta = ControllerUsuarios::ctrMostrarUsuario("idUsuario", $_POST["idUsuario"]);
		echo json_encode($respuesta);

	}

    public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item ="login";
		$valor = $this->validarUsuario;

		$respuesta = ControllerUsuarios::ctrMostrarUsuario($item, $valor);
		echo json_encode($respuesta);

	}
    

    public $idUsuario;
    public $idEmpleado;
    public $idAlmacen;
    public $login;
    public $passActual;
    public $passlogin;
    public $idPerfil;
    public $estado;
    

    /*=============================================
	Nueva Tipo Documento
	=============================================*/
    public function ajaxNuevoUsuarios()
    {
        $datos = array(
            "idEmpleado" => $this->idEmpleado,
            "idAlmacen" => $this->idAlmacen,
            "login" => $this->login,
            "passlogin" => $this->passlogin,
            "idPerfil" => $this->idPerfil
        );
        $respuesta = ControllerUsuarios::ctrCrearUsuario($datos);
        echo $respuesta;
    }


    /*=============================================
	EditarUsuarios
	=============================================*/

    public function ajaxEditarUsuarios()
    { 
        $datos = array(
            "idUsuario" => $this->idUsuario,
            "idEmpleado" => $this->idEmpleado,
            "idAlmacen" => $this->idAlmacen,
            "login" => $this->login,
            "passActual" => $this->passActual,
            "passlogin" => $this->passlogin,
            "idPerfil" => $this->idPerfil
        );

        $respuesta = ControllerUsuarios::ctrEditarUsuario($datos);
        echo $respuesta;
    }
   
      /*=============================================
	Eliminar Usuarios
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarUsuarios(){
		$respuesta = ControllerUsuarios::ctrBorrarUsuario($this->idEliminar);
		echo $respuesta;
	}



}

/*=============================================
Guardar y Editar Persona
=============================================*/

if (isset($_POST["idEmpleado"])) {

    $usuarios = new AjaxUsuario();
    $usuarios->idEmpleado = $_POST["idEmpleado"];
    $usuarios->idAlmacen = $_POST["idAlmacen"];
    $usuarios->login = $_POST["login"];

    if($_POST["passlogin"] != ""){
    	$usuarios -> passlogin = $_POST["passlogin"];
    }else{
    	$usuarios -> passActual = $_POST["passActual"];
    }


    $usuarios->idPerfil = $_POST["idPerfil"];
   
    if($_POST["idUsuario"] != ""){

    	$usuarios -> idUsuario = $_POST["idUsuario"];
    	$usuarios -> ajaxEditarUsuarios();
        
    }else{
    	$usuarios -> ajaxNuevoUsuarios();

    }

}

/*=============================================
Ver Persona
=============================================*/	

if(isset($_POST["ajaxUsuarios"])){
	$leerUsuarios = new AjaxUsuario();
	$leerUsuarios -> ajaxMostrarUsuarios();
}

/*=============================================
VALIDAR USUARIO
=============================================*/	
if (isset($_POST["validarUsuario"])) {
	
	$valUsuario = new AjaxUsuario();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}


/*=============================================
Eliminar Tipopago
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxUsuario();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarUsuarios();

}