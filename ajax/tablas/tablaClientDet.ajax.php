<?php
session_start();
//vamos a requerir el controlador y el modelo

require_once "../../controllers/clientes.controller.php";
require_once "../../models/clientes.model.php";

require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaClientDet
{

    public function mostrarTabla()
    {
        
        $idVenta = $_GET["idVenta"];
        $detClient = ControllerClientes::ctrMostrarDetalleClient($idVenta);
        if (count($detClient) == 0) {
            $datosJson = '[]';
            echo $datosJson;  
            return;
        }

        
       $datosJson = '[';
      

        foreach ($detClient as $key => $value) {
                $configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

                $datosJson .= '{
                            "idVenta": "' .  $value["idVenta"] . '",
                            "codigo_producto": "' . $value["codigo_producto"] . '",
                            "descProducto": "' . $value["descProducto"] . '",
                            "precio_venta":  " '.$configuracion[0]["simbolom"].' ' . $value["precio_venta"] . '",
                            "cantidad": "' . $value["cantidad"] . '",
                            "total_venta":  " '.$configuracion[0]["simbolom"].' ' . $value["total_venta"] . '"
                           
                        },';

            
        }

        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=  ']';

        
        echo $datosJson;
        
    }
}

$tabla = new TablaClientDet();
$tabla->mostrarTabla();