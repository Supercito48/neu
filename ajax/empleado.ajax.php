<?php

require_once "../controllers/empleado.controller.php";
require_once "../models/empleado.model.php";

class AjaxEmpleado{

	public $idEmpleado;
	public $id;
	public $nombres;
	public $apellidos;
	public $telefono;			
	public $direccion;
	public $dni;
	public $correo;
	public $fecNacimiento;
	public $foto;
    public $antiguaFoto;

	public function ajaxMostrarEmpleados(){


		$item = "idEmpleado";
		$valor = $this->id;

		$respuesta = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);

		echo json_encode($respuesta);
	//	$respuesta = ControllerEmpleado::ctrMostrarEmpleado("idEmpleado", $_POST["idEmpleado"]);
	//	echo json_encode($respuesta);

	}

	public function ajaxValidarDni(){

		$item ="dni";
		$valor = $this->dni;

		$respuesta = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);
		echo json_encode($respuesta);

	}
	
	public function ajaxCrearEmpleado(){

		$datos = array(
			"nombres"=>$this->nombres,
			"apellidos"=>$this->apellidos,
			"telefono"=>$this->telefono,
			"direccion"=>$this->direccion,					
			"dni"=>$this->dni,
			"correo"=>$this->correo,
			"fecNacimiento"=>$this->fecNacimiento,
			"foto"=>$this->foto
			);

		$respuesta = ControllerEmpleado::ctrCrearEmpleado($datos);

		echo $respuesta;

	}

	public function ajaxEditarEmpleado(){

		$datos = array(
			"id" => $this->idEmpleado,
			"nombres"=>$this->nombres,
			"apellidos"=>$this->apellidos,
			"telefono"=>$this->telefono,
			"direccion"=>$this->direccion,					
			"dni"=>$this->dni,
			"correo"=>$this->correo,
			"fecNacimiento"=>$this->fecNacimiento,
			"foto"=>$this->foto,
            "antiguaFoto"=>$this->antiguaFoto,
			);

		$respuesta = ControllerEmpleado::ctrEditarEmpleado($datos);

		echo $respuesta;

	}

	/*=============================================
	Eliminar habitación
	=============================================*/	

	public $idEliminar;
	public $fotoEliminar;

	public function ajaxEliminarEmpleado(){
	
		$datos = array( "idEliminar" => $this->idEliminar,
						"fotoEliminar" => $this->fotoEliminar);

		$respuesta = ControllerEmpleado::ctrEliminarEmpleado($datos);

		echo $respuesta;

	}

}


if(isset($_POST["id"])){
//	$leerEmpleado = new AjaxEmpleado();
//	$leerEmpleado -> ajaxMostrarEmpleados();

	$leerEmpleado = new AjaxEmpleado();
	$leerEmpleado -> id = $_POST["id"];
	$leerEmpleado -> ajaxMostrarEmpleados();

}

if (isset($_POST["ajaxValidarDni"])) {
	
	$leerEmpleado = new AjaxEmpleado();
	$leerEmpleado -> dni = $_POST["ajaxValidarDni"];
	$leerEmpleado -> ajaxValidarDni();

}

#CREAR PRODUCTO
#-----------------------------------------------------------


if(isset($_POST["nombres"])){

	$empleado = new AjaxEmpleado();
	$empleado -> nombres = $_POST["nombres"];
	$empleado -> apellidos = $_POST["apellidos"];
	$empleado -> telefono = $_POST["telefono"];
	$empleado -> direccion = $_POST["direccion"];		
	$empleado -> dni = $_POST["dni"];
	$empleado -> correo = $_POST["correo"];
	$empleado -> fecNacimiento = $_POST["fecNacimiento"];
	
	if(isset($_FILES["foto"])){
		$empleado -> foto = $_FILES["foto"];
	}else{
		$empleado -> foto = null;
	}

    $empleado -> ajaxCrearEmpleado();

}


/*=============================================
EDITAR PRODUCTO
=============================================*/
if(isset($_POST["idEmpleado"])){

	$editarEmpleado = new AjaxEmpleado();

	$editarEmpleado -> idEmpleado = $_POST["idEmpleado"];
	$editarEmpleado -> nombres = $_POST["editarnombres"];
	$editarEmpleado -> apellidos = $_POST["apellidos"];
	$editarEmpleado -> telefono = $_POST["telefono"];
	$editarEmpleado -> direccion = $_POST["direccion"];		
	$editarEmpleado -> dni = $_POST["dni"];
	$editarEmpleado -> correo = $_POST["correo"];
	$editarEmpleado -> fecNacimiento = $_POST["fecNacimiento"];
	

	if(isset($_FILES["foto"])){

		$editarEmpleado -> foto = $_FILES["foto"];

	}else{

		$editarEmpleado -> foto = null;

	}	
	$editarEmpleado -> antiguaFoto = $_POST["antiguaFoto"];
	
	$editarEmpleado -> ajaxEditarEmpleado();

}

/*=============================================
Eliminar Empleado
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxEmpleado();
    $eliminar -> idEliminar = $_POST["idEliminar"];
    $eliminar -> fotoEliminar = $_POST["fotoEliminar"];
    $eliminar -> ajaxEliminarEmpleado();
	
}