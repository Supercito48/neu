<?php

require_once "../controllers/producto.controller.php";
require_once "../models/producto.model.php";

class AjaxProducto
{

    // /*=============================================
	// Editar Producto traer datos al modal
	// =============================================*/	

	public function ajaxMostrarProducto(){

		$respuesta = ControllerProducto::ctrMostrarProducto("idProducto", $_POST["idProducto"]);
		echo json_encode($respuesta);

	}
    
// /*=============================================
	// COMPRAS
	// =============================================*/	
    public function ajaxListarProductosCompra(){

        $NombreProductos = ControllerProducto::ctrListarProductoCompra();
        echo json_encode($NombreProductos);
    }

    public function ajaxGetDatosProductoCompra(){
    
        $producto = ControllerProducto::ctrGetDatosProductoCompra($this->codigo_producto);
        echo json_encode($producto);
    }

    // /*=============================================
	// Ventas
	// =============================================*/	
    
    public function ajaxListarProductos(){

        $productos = ControllerProducto::ctrListarProductos($this->idAlmacen);

        echo json_encode($productos);
    }

    public function ajaxGetDatosProducto(){
    
        $producto = ControllerProducto::ctrGetDatosProductos($this->codigo_producto,$this->idAlmacen);

        echo json_encode($producto);
    }

    public function ajaxVerificaStockProducto(){
    
        $respuesta = ControllerProducto::ctrVerificaStockProducto($this->codigo_producto,$this->cantidad_a_comprar, $this->idAlmacen);

       echo json_encode($respuesta);
   }

    public function ajaxEditarPrecio(){

        $editarPrecio = ControllerProducto::ctrEditarPrecio($this->idProducto,$this->precioCompra);
        echo json_encode($editarPrecio);

    }

    


    public $idProducto;
    public $descProducto;
    public $codigoBarras;
	public $idCategoria;
    public $precioCompra;
    public $precioVenta;
    public $precioVentaMA;

    public $oferta;
    
    

    
  /*=============================================
	Nuevo Producto
	=============================================*/
    public function ajaxNuevoProducto()
    {
        $datos = array(
            "descProducto" => $this->descProducto,
			"codigoBarras" => $this->codigoBarras,
			"idCategoria" => $this->idCategoria,
            "precioCompra" => $this->precioCompra,
			"precioVenta" => $this->precioVenta,
            "precioVentaMA" => $this->precioVentaMA,
            "oferta" => $this->oferta,
        );
        $respuesta = ControllerProducto::ctrCrearProducto($datos);
        echo $respuesta;
    }


    /*=============================================
	Editar Producto
	=============================================*/

    public function ajaxEditarProducto()
    {
        $datos = array(
            "idProducto" => $this->idProducto,
            "descProducto" => $this->descProducto,
			"codigoBarras" => $this->codigoBarras,
			"idCategoria" => $this->idCategoria,
            "precioCompra" => $this->precioCompra,
			"precioVenta" => $this->precioVenta,
            "precioVentaMA" => $this->precioVentaMA,
            "oferta" => $this->oferta,
        );

        $respuesta = ControllerProducto::ctrEditarProducto($datos);
        echo $respuesta;
    }

   

   
     /*=============================================
	Eliminar Producto
	=============================================*/
	public $idEliminar;

	public function ajaxEliminarProducto(){
		$respuesta = ControllerProducto::ctrBorrarProducto($this->idEliminar);
		echo $respuesta;
	}

    //

    public function ajaxMostrarBajosInv(){
        $respuesta = ControllerProducto::ctrMostrarBajosInv($this->idAlmacen);
        echo json_encode($respuesta);
    }

    public function ajaxMostrarBajosInvD(){
        $respuesta = ControllerProducto::ctrMostrarBajosInvD($this->idAlmacen);
        echo json_encode($respuesta);
    }

    public function ajaxMostrarMasVendido(){
        $respuesta = ControllerProducto::ctrMostrarMasVendido($this->idAlmacen);
        echo json_encode($respuesta);
    }
    

}

/*=============================================
Guardar y Editar Producto
=============================================*/

if (isset($_POST["descProducto"])) {

    $tipoProducto = new AjaxProducto();
    $tipoProducto->descProducto = $_POST["descProducto"];
	$tipoProducto->codigoBarras = $_POST["codigoBarras"];
	$tipoProducto->idCategoria = $_POST["idCategoria"];
    $tipoProducto->precioCompra = $_POST["precioCompra"];
	$tipoProducto->precioVenta = $_POST["precioVenta"];
    $tipoProducto->precioVentaMA = $_POST["precioVentaMA"];
    $tipoProducto->oferta = $_POST["oferta"];
   
    if($_POST["idProducto"] != ""){

    	$tipoProducto -> idProducto = $_POST["idProducto"];
    	$tipoProducto -> ajaxEditarProducto();
        
    }else{
    	$tipoProducto -> ajaxNuevoProducto();
    }

}

if(isset($_POST["ajaxEditarPrecio"])){
	$editarPrecio = new AjaxProducto();
    $editarPrecio -> idProducto = $_POST["idProducto"];
    $editarPrecio -> precioCompra = $_POST["precioCompra"];
	$editarPrecio -> ajaxEditarPrecio();
}


/*=============================================
Ver Producto
=============================================*/	

if(isset($_POST["ajaxProducto"])){
	$leerProducto = new AjaxProducto();
	$leerProducto -> ajaxMostrarProducto();
}

/*=============================================
Eliminar Producto
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxProducto();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> ajaxEliminarProducto();

}

/*=============================================
AutoCompletado COMPRAS
=============================================*/	

if(isset($_POST["ajaxAutoComProducto"])){
    $nombreProductos = new AjaxProducto();
    //$nombreProductos -> idAlmacen = $_POST["idAlmacen"];
    $nombreProductos -> ajaxListarProductosCompra();
}
/*=============================================
OBTENER DATOS DE UN PRODUCTO POR SU CODIGO PARA compras
=============================================*/	
if(isset($_POST["ajaxGestorProductoC"])){
    $listaProducto = new AjaxProducto();
    $listaProducto -> codigo_producto = $_POST["codigo_producto"];
    $listaProducto -> ajaxGetDatosProductoCompra();
}

/*=============================================
AutoCompletado Ventas
=============================================*/	

if(isset($_POST["ajaxAutoProductoVenta"])){
    $productos = new AjaxProducto();
    $productos -> idAlmacen = $_POST["idAlmacen"];
    $productos -> ajaxListarProductos();
}

/*=============================================
OBTENER DATOS DE UN PRODUCTO POR SU CODIGO PARA 
=============================================*/	

if(isset($_POST["ajaxGestorProductoV"])){
    $listaProducto = new AjaxProducto();
    $listaProducto -> codigo_producto = $_POST["codigo_producto"];
    $listaProducto -> idAlmacen = $_POST["idAlmacen"];
    $listaProducto -> ajaxGetDatosProducto();
}

if(isset($_POST["ajaxVerificarStock"])){
    $verificaStock = new AjaxProducto();
    $verificaStock -> codigo_producto = $_POST["codigo_producto"];
    $verificaStock -> cantidad_a_comprar = $_POST["cantidad_a_comprar"];
    $verificaStock -> idAlmacen = $_POST["idAlmacen"];

    $verificaStock -> ajaxVerificaStockProducto();

}

//

if(isset($_POST["ajaxMostrarBajosInv"])){
    $productobi = new AjaxProducto();
    $productobi -> idAlmacen = $_POST["idAlmacen"];
    $productobi -> ajaxMostrarBajosInv();
}

if(isset($_POST["ajaxMostrarBajosInvD"])){
    $productobi = new AjaxProducto();
    $productobi -> idAlmacen = $_POST["idAlmacen"];
    $productobi -> ajaxMostrarBajosInvD();
}

if(isset($_POST["ajaxMostrarMasVendido"])){
    $productobCero = new AjaxProducto();
    $productobCero -> idAlmacen = $_POST["idAlmacen"];
    $productobCero -> ajaxMostrarMasVendido();
}