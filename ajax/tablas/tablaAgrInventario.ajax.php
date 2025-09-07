<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/inventario.controller.php";
require_once "../../models/inventario.model.php";

require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

class TablaAgrInventario
{

    /*=============================================
	Tabla Personas
	=============================================*/

    public function mostrarTabla()
    {
        
        $idAlmacen = $_GET["idAlmacen"];
        $verinventarioAgr = ControllerProducto::ctrMostrarProductoInventario($idAlmacen);
        if (count($verinventarioAgr) == 0) {
            $datosJson = '[]';
            echo $datosJson;  
            return;
        }

        
       $datosJson = '[';
      

        foreach ($verinventarioAgr as $key => $value) {


                $acciones = "<button type='button' idProducto = '".$value["idProducto"]."' idUsuario = '".$_SESSION["idUsuario"]."' class='btn btn-success guardarInventario'><i class='fa fa-check'></i></button>";
                
                $stock = "<input type='number' name='stock' id='stock' class='form-control stock' onkeypress='return soloNumeros(event)' min='0' max='9999' maxlength='4' oninput='if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>";
                $stock_minimo = "<input type='number' name='stock_minimo' id='stock_minimo' class='form-control stock_minimo' onkeypress='return soloNumeros(event)' min='0' max='9999' maxlength='4' oninput='if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>";


                $datosJson .= '{
                            "descProducto": "' . $value["descProducto"] . '",
                            "codigoBarras": "' . $value["codigoBarras"] . '",
                            "stock": "' . $stock . '",
                            "stock_minimo": "' . $stock_minimo . '",
                            "acciones" : "' . $acciones . '"
                        },';

            
        }

        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=  ']';

        
        echo $datosJson;
        
    }
}

$tabla = new TablaAgrInventario();
$tabla->mostrarTabla();
