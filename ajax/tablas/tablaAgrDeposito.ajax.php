<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/deposito.controller.php";
require_once "../../models/deposito.model.php";

require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

class TablaAgrDeposito
{

    /*=============================================
	Tabla Personas
	=============================================*/

    public function mostrarTabla()
    {
        
        $verdepositoAgr = ControllerProducto::ctrMostrarProductoDeposito();
        if (count($verdepositoAgr) == 0) {
            $datosJson = '[]';
            echo $datosJson;

            
            return;
        }

        
       $datosJson = '[';
      

        foreach ($verdepositoAgr as $key => $value) {

            //$depositonulo = ControllerDeposito::ctrMostrarDepositoProducto($value["idProducto"]);

            
           
            //if ($depositonulo == null){

                $acciones = "<button type='button' idProducto = '".$value["idProducto"]."' class='btn btn-success guardarDeposito'><i class='fa fa-check'></i></button>";
                
                $stock = "<input type='number' name='stock' id='stock' class='form-control stock' onkeypress='return soloNumeros(event)' min='0' max='9999' maxlength='4' oninput='if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>";

                $datosJson .= '{
                            "codigoBarras": "' . $value["codigoBarras"] . '",
                            "descProducto": "' . $value["descProducto"] . '",
                            "stock": "' . $stock . '",
                            "acciones" : "' . $acciones . '"
                        },';

               // $datosJson = substr($datosJson, 0, -1);
            //} 

           
            
        }

        $datosJson = substr($datosJson, 0, -1);
       //$datosJson = $datosJson;
        $datosJson .=  ']';

        
        echo $datosJson;
        
    }
}

$tabla = new TablaAgrDeposito();
$tabla->mostrarTabla();
