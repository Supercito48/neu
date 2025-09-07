<?php

require_once "../controllers/categoria.controller.php";
require_once "../models/categoria.model.php";

class AjaxCategoria
{
    // /*=============================================
	// Editar categoria traer datos al modal
	// =============================================*/	
	public function ajaxMostrarCategoria(){

		$respuesta = ControllerCategorias::ctrMostrarCategorias("idCategoria", $_POST["idCategoria"]);
		echo json_encode($respuesta);

	}

    public $idCategoria;
    public $desCat;
    
    /*=============================================
	Nueva Tipo Documento
	=============================================*/
    public function ajaxNuevoCategoria()
    {
        $datos = array(
            "desCat" => $this->desCat,
        );
        $respuesta = ControllerCategorias::ctrCrearCategoria($datos);
        echo $respuesta;
    }


    /*=============================================
	Editar Tipo Documento
	=============================================*/

    public function ajaxEditarCategoria()
    {
        $datos = array(
            "idCategoria" => $this->idCategoria,
            "desCat" => $this->desCat,
        );

        $respuesta = ControllerCategorias::ctrEditarCategoria($datos);
        echo $respuesta;
    }
    /*=============================================
	Activar o desactivar Tipo Documento
	=============================================*/
    
	public $estadoCat;

	public function ajaxActivarCategoria(){

		$tabla = "categoria";

		$item2 = "estadoCat";
		$valor2 = $this->estadoCat;

		$item1 = "idCategoria";
		$valor1 = $this->idCategoria;

		$respuesta = ModelCategorias::mdlActualizarCategoria($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;

	}	

     /*=============================================
	Eliminar Tipo Documento
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarCategoria(){
		$respuesta = ControllerCategorias::ctrBorrarCategoria($this->idEliminar);
		echo $respuesta;
	}



}

/*=============================================
Guardar y Editar Persona
=============================================*/

if (isset($_POST["desCat"])) {

    $tipocategoria = new AjaxCategoria();
    $tipocategoria->desCat = $_POST["desCat"];
   
    if($_POST["idCategoria"] != ""){

    	$tipocategoria -> idCategoria = $_POST["idCategoria"];
    	$tipocategoria -> ajaxEditarCategoria();
        
    }else{
    	$tipocategoria -> ajaxNuevoCategoria();
    }

}

/*=============================================
Ver Persona
=============================================*/	

if(isset($_POST["ajaxCategoria"])){
	$leerCategoria = new AjaxCategoria();
	$leerCategoria -> ajaxMostrarCategoria();
}

/*=============================================
Activar o desactivar Tipo Documento
=============================================*/	

if(isset($_POST["estadoCat"])){
	$activarCategoria = new AjaxCategoria();
	$activarCategoria -> idCategoria = $_POST["idCategoria"];
	$activarCategoria -> estadoCat = $_POST["estadoCat"];
	$activarCategoria -> ajaxActivarCategoria();
}

/*=============================================
Eliminar Persona
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxCategoria();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarCategoria();

}