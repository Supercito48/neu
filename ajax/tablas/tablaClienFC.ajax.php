<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/clientes.controller.php";
require_once "../../models/clientes.model.php";

class TablaClientFC
{

    public function mostrarTabla()
    {
        
        $idCliente = $_GET["idCliente"];
        $verFecha = ControllerClientes::ctrMostrarFechaClient($idCliente);
        if (count($verFecha) == 0) {
            $datosJson = '[]';
            echo $datosJson;  
            return;
        }

        
       $datosJson = '[';
      

        foreach ($verFecha as $key => $value) {


                $acciones = "<button type='button' class='btn btn-success btnVerDetalle'><i class='fa fa-check'></i></button>";
            

                $datosJson .= '{
                            "id": "' . ($key + 1) . '",
                            "fecha": "' . $value["fecha"] . '",
                            "idVenta": "' . $value["idVenta"] . '",
                            "acciones": "' . $acciones . '"
                           
                        },';

            
        }

        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=  ']';

        
        echo $datosJson;
        
    }
}

$tabla = new TablaClientFC();
$tabla->mostrarTabla();