<?php


require_once "../controllers/kardex.controller.php";
require_once "../models/kardex.model.php";

class AjaxKardex
{

    // /*=============================================
	// Editar Inventario traer datos al modal
	// =============================================*/	

	public function ajaxMostrarKardex(){

		$respuesta = ControllerKardex::VerProductosKardex("idKardex", $_POST["idKardex"],null,null);
		echo json_encode($respuesta);

	}
    

    public $idKardex;

	public $idProducto;
	public $idAlmacen;
    public $stock;
	public $idUsuario;

	public $habia;
	public $hay;
	public $destinodesc;


    
  /*=============================================
	Nuevo Kardex
	=============================================*/
    public function ajaxNuevoKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
          
        );
        $respuesta = ControllerKardex::ctrCrearKardex($datos);
        echo $respuesta;


		
    }

	/*=============================================
	Aumento Kardex
	=============================================*/
    public function ajaxAumentoKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
			"habia" => $this->habia,
			"hay"=> $this->hay,
          
        );
        $respuesta = ControllerKardex::ctrAumentoKardex($datos);
        echo $respuesta;

    }

	
	/*=============================================
	Aumento Kardex
	=============================================*/
    public function ajaxAjusteKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
			"habia" => $this->habia,
			"hay"=> $this->hay,
          
        );
        $respuesta = ControllerKardex::ctrAjusteKardex($datos);
        echo $respuesta;

    }

	/*=============================================
	TRANSFERENCIA INVENTARIO Kardex
	=============================================*/
    public function ajaxSalidaTKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
			"habia" => $this->habia,
			"hay"=> $this->hay,
			"destinodesc"=> $this->destinodesc,
          
        );
        $respuesta = ControllerKardex::ctrSalidaTKardex($datos);
        echo $respuesta;

    }

	/*=============================================
	TRANSFERENCIA RECIBE Kardex
	=============================================*/
    public function ajaxEntradaTKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
			"habia" => $this->habia,
			"hay"=> $this->hay,
			"destinodesc"=> $this->destinodesc,
          
        );
        $respuesta = ControllerKardex::ctrEntradaTKardex($datos);
        echo $respuesta;

    }

	
	/*=============================================
	Eliminar Inventario
	=============================================*/
    public function ajaxEliminarInventarioKardex()
    {
        $datos = array(

			"idAlmacen" => $this->idAlmacen,
			"idProducto" => $this->idProducto,
            "stock" => $this->stock,
			"idUsuario" => $this->idUsuario,
			
        );
        $respuesta = ControllerKardex::ctrEliminarInventarioKardex($datos);
        echo $respuesta;

    }



 

}

/*=============================================
Guardar Kardex
=============================================*/

if (isset($_POST["idProducto"])) {

    $tipokardex = new AjaxKardex();
	$tipokardex->idAlmacen = $_POST["idAlmacen"];
	$tipokardex->idProducto = $_POST["idProducto"];
    $tipokardex->stock = $_POST["stock"];
	$tipokardex->idUsuario = $_POST["idUsuario"];
   
    $tipokardex -> ajaxNuevoKardex();

}

/*=============================================
Aumentar stock Kardex
=============================================*/

if (isset($_POST["AidAlmacen"])) {

    $aumentoKardex = new AjaxKardex();
	$aumentoKardex->idAlmacen = $_POST["AidAlmacen"];
	$aumentoKardex->idProducto = $_POST["AidProducto"];
    $aumentoKardex->stock = $_POST["Astock"];
	$aumentoKardex->idUsuario = $_POST["AidUsuario"];
	$aumentoKardex->habia = $_POST["Ahabia"];
	$aumentoKardex->hay = $_POST["Ahay"];
   
    $aumentoKardex -> ajaxAumentoKardex();
  
}

/*=============================================
Ajustar stock Kardex
=============================================*/

if (isset($_POST["AJidAlmacen"])) {

    $aumentoKardex = new AjaxKardex();
	$aumentoKardex->idAlmacen = $_POST["AJidAlmacen"];
	$aumentoKardex->idProducto = $_POST["AJidProducto"];
    $aumentoKardex->stock = $_POST["AJstock"];
	$aumentoKardex->idUsuario = $_POST["AJidUsuario"];
	$aumentoKardex->habia = $_POST["AJhabia"];
	$aumentoKardex->hay = $_POST["AJhay"];
   
    $aumentoKardex -> ajaxAjusteKardex();
  
}

/*=============================================
Salida Traslado stock Kardex
=============================================*/

if (isset($_POST["TidAlmacen"])) {

    $aumentoKardex = new AjaxKardex();
	$aumentoKardex->idAlmacen = $_POST["TidAlmacen"];
	$aumentoKardex->idProducto = $_POST["TidProducto"];
    $aumentoKardex->stock = $_POST["Tstock"];
	$aumentoKardex->idUsuario = $_POST["TidUsuario"];
	$aumentoKardex->habia = $_POST["Thabia"];
	$aumentoKardex->hay = $_POST["Thay"];
   
	$aumentoKardex->destinodesc = $_POST["Tdestinodesc"];

    $aumentoKardex -> ajaxSalidaTKardex();
  
}

/*=============================================
Entrada Traslado stock Kardex
=============================================*/

if (isset($_POST["ETidAlmacen"])) {

    $aumentoKardex = new AjaxKardex();
	$aumentoKardex->idAlmacen = $_POST["ETidAlmacen"];
	$aumentoKardex->idProducto = $_POST["ETidProducto"];
    $aumentoKardex->stock = $_POST["ETstock"];
	$aumentoKardex->idUsuario = $_POST["ETidUsuario"];
	$aumentoKardex->habia = $_POST["EThabia"];
	$aumentoKardex->hay = $_POST["EThay"];
   
	$aumentoKardex->destinodesc = $_POST["ETdestinodesc"];

    $aumentoKardex -> ajaxEntradaTKardex();
  
}


/*=============================================
Eliminar inventario Kardex
=============================================*/

if (isset($_POST["ELidProducto"])) {

    $tipokardex = new AjaxKardex();
	$tipokardex->idAlmacen = $_POST["ELidAlmacen"];
	$tipokardex->idProducto = $_POST["ELidProducto"];
    $tipokardex->stock = $_POST["ELstock"];
	$tipokardex->idUsuario = $_POST["ELidUsuario"];
   
    $tipokardex -> ajaxEliminarInventarioKardex();

}