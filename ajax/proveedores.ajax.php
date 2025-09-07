<?php

require_once "../controllers/proveedores.controller.php";
require_once "../models/proveedores.model.php";

class AjaxProveedores
{
    // /*=============================================
	// Editar categoria traer datos al modal
	// =============================================*/	
	public function ajaxMostrarProveedores(){

		$respuesta = ControllerProveedores::ctrMostrarProveedores("idProveedor", $_POST["idProveedor"]);
		echo json_encode($respuesta);

	}

    public $idProveedor;
    public $RUC;
    public $nombre;
    public $direccion;
    public $celular;
    public $telefono;
    public $email;
    
    /*=============================================
	Nueva Tipo Documento
	=============================================*/
    public function ajaxNuevoProveedores()
    {
        $datos = array(
            "RUC" => $this->RUC,
            "nombre" => $this->nombre,
            "direccion" => $this->direccion,
            "celular" => $this->celular,
            "telefono" => $this->telefono,
            "email" => $this->email,
        );
        $respuesta = ControllerProveedores::ctrCrearProveedores($datos);
        echo $respuesta;
    }


    /*=============================================
	Editar Tipo Documento
	=============================================*/

    public function ajaxEditarProveedores()
    {
        $datos = array(
            "idProveedor" => $this->idProveedor,
            "RUC" => $this->RUC,
            "nombre" => $this->nombre,
            "direccion" => $this->direccion,
            "celular" => $this->celular,
            "telefono" => $this->telefono,
            "email" => $this->email,
        );

        $respuesta = ControllerProveedores::ctrEditarProveedores($datos);
        echo $respuesta;
    }
     /*=============================================
	Eliminar Tipo Documento
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarProveedores(){
		$respuesta = ControllerProveedores::ctrBorrarProveedores($this->idEliminar);
		echo $respuesta;
	}



}

/*=============================================
Guardar y Editar 
=============================================*/

if (isset($_POST["nombre"])) {

    $tipoproveedor = new AjaxProveedores();
    $tipoproveedor->RUC = $_POST["RUC"];
    $tipoproveedor->nombre = $_POST["nombre"];
    $tipoproveedor->direccion = $_POST["direccion"];
    $tipoproveedor->celular = $_POST["celular"];
    $tipoproveedor->telefono = $_POST["telefono"];
    $tipoproveedor->email = $_POST["email"];
   
    if($_POST["idProveedor"] != ""){

    	$tipoproveedor -> idProveedor = $_POST["idProveedor"];
    	$tipoproveedor -> ajaxEditarProveedores();
        
    }else{
    	$tipoproveedor -> ajaxNuevoProveedores();
    }

}

/*=============================================
Ver Persona
=============================================*/	

if(isset($_POST["ajaxProveedores"])){
	$leerProveedores = new AjaxProveedores();
	$leerProveedores -> ajaxMostrarProveedores();
}


/*=============================================
Eliminar Persona
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxProveedores();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarProveedores();

}